<?php

class UserController extends Controller
{
    /**
        * Declares class-based actions.
        */
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl',
        );
    }
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('admin', 'index', 'update', 'create', 'delete', 'view'),
                'roles'=>array('admin'),
            ),
            array('allow',
                'actions'=>array('registration','activation'),
                'roles'=>array('guest'),
            ),
            array('allow',
                'actions'=>array('captcha','recovery', 'changePassword'),
                'users'=>array('*'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    /**
    * This is the default 'index' action that is invoked
    * when an action is not explicitly requested by users.
    */

    public function actionIndex()
    {
        $this->redirect(Yii::app()->createUrl('user/admin'));
    }


    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $this->render('view',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $user = $this->loadModel($id);

        if(Yii::app()->user->organization == $user->org->organization_id) {
            $model = new UserForm('update');
            $model->unsetAttributes();  // clear any default values

            $model->attributes = $user->getAttributes();
            $data = Yii::app()->request->getParam('UserForm');

            if($data) {
                $model->attributes=$data;
                if($model->validate()) {
                    $user->attributes = $model->getAttributes();
                    if($model->newPassword != NULL) {
                        $user->userPassword = $model->newPassword;
                        $user->password = $model->newPassword;
                    }
                    if($user->save()) {
                        MailHelper::sendCustomMail(Yii::app()->user->adminEmail, $user->email, 'Update account', 'user_update_msg', array('model' => $user));
                        $this->redirect($this->createUrl('user/admin'));
                    }
                }
            }

            $this->render('update',array(
                'model'=>$model,
                'user'=>$user,
            ));
        } else
            throw new CHttpException(403,'You are not authorized to perform this action.');
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'admin' page.
     */
    public function actionCreate()
    {
        $user = new User();
        $model = new UserForm('create');
        $model->unsetAttributes();  // clear any default values

        $data = Yii::app()->request->getParam('UserForm');
        if($data) {
            $model->attributes = $data;
            if($model->validate()) {
                $user->attributes = $model->getAttributes();
                $user->userPassword = $model->password;

                if($user->save()) {
                    //Get all user ids in current organization
                    $users = User::model()->findAll(array(
                        'select'=>'id',
                        'condition'=>'organization__id=:cond',
                        'params'=>array(':cond'=>$user->organization__id)
                    ));

                    //Get all experiments and set access for new user
                    $criteria = new CDbCriteria();
                    $criteria->select = "experiment_id";
                    $criteria->addInCondition('user__id', CHtml::ListData($users, 'id', 'id'));
                    $criteria->distinct = true;
                    $experiments = Experiments::model()->findAll($criteria);

                    foreach($experiments as $exp) {
                        $access = new AccessGrants();
                        $access->experiment__id = $exp->experiment_id;
                        $access->user__id = $user->id;
                        $access->level = AccessGrants::REVIEWER_LEVEL;
                        $access->save();
                    }

                    MailHelper::sendCustomMail(Yii::app()->user->adminEmail, $user->email, 'Registration account', 'registration_msg', array('model' => $user));
                    $this->redirect($this->createUrl('user/admin'));
                }
            }
        }
        $this->render('create', array('model'=>$model, 'user'=>$user));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $model = $this->loadModel($id);
            if(Yii::app()->user->organization == $model->org->organization_id) {
                $model->status = User::STATUS_INACTIVE;
                $model->save();
                $experiments = Experiments::model()->findAll('user__id=:cond', array(':cond'=>$model->id));
                if($experiments != null) {
                    foreach($experiments as $exp) {
                        $exp->locked = true;
                        $exp->save();
                    }
                }
            } else
                throw new CHttpException(403,'You are not authorized to perform this action.');

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    public function actionRegistration()
    {
        $regForm = new RegistrationForm();
        $regForm->unsetAttributes();  // clear any default values
        $user = new User();
        $org = new Organizations();
        $membership = new Memberships();

        $data = Yii::app()->request->getParam('RegistrationForm');

        if($data) {
            $regForm->attributes = $data;
            if($regForm->validate()) {
                    $user->attributes = $regForm->getAttributes();
                    $user->userPassword = $regForm->password;
                    $org->name = $regForm->organization;
                    if($org->validate() && $user->validate()) {
                            $org->save();
                            $user->save();

                            $membership->organization__id = $org->organization_id;
                            $membership->user__id = $user->id;
                            $membership->level = "manager";
                            $membership->save();

                            MailHelper::sendCustomMail(Yii::app()->params['adminEmail'], $user->email, 'Registration account', 'registration_msg', array('model' => $user));
                            $this->redirect($this->createUrl('/site/confirmemail'));
                    }
            }
        }
        $this->render('//registration/registration', array('model'=>$regForm, 'user'=>$user, 'org'=>$org));
    }
    
    public function actionActivation()
    {
        $key = Yii::app()->request->getParam('key');
        if($key) {
            $model = User::model()->find('"t"."activationKey"=:key', array(':key'=>$key));

            if ($model === null)
                throw new CHttpException('404', 'The requested page does not exist.');

            $model->setAttributes(array(
                'activationKey' => null,
                'status' => 1,
            ));
            if($model->save()) {
                $this->render('//registration/activation_success');
            }
        } else
            throw new CHttpException('404', 'The requested page does not exist.');
    }

    /**
    * Recovery password
    */
    public function actionRecovery()
    {
        $model = new RecoveryForm('recovery');
        $data = Yii::app()->request->getParam('RecoveryForm');

        if ($data) {
            $model->attributes = $data;

            if ($model->validate()) {
                $user = User::model()->find('email=:cond OR username=:cond', array(':cond' => $data["login_or_email"]));
                if ($user !== null) {

                    $user->attributes = $model->getAttributes(array(
                        'activationKey',
                        'status'
                    ));

                    if($user->save()) {
                        MailHelper::sendCustomMail(Yii::app()->params['adminEmail'], $user->email, 'Recovery password', 'recovery_password_msg', array('model' => $user));
                        Yii::app()->user->setFlash('success', 'Please check your mail for further instructions.');
                        $this->redirect(Yii::app()->createUrl('user/recovery'));
                    }
                }
            }
        }
        $this->render('//registration/recovery', array('model' => $model));
    }

    /**
     * Change password
     */
    public function actionChangePassword()
    {
        $key = Yii::app()->request->getParam('key');
        $data = Yii::app()->request->getParam('RecoveryForm');

        if($key) {
            $user = User::model()->find('"t"."activationKey"=:key', array(':key'=>$key));
            if ($user != null) {
                $model = new RecoveryForm('change');
                if($data) {
                    $model->attributes = $data;
                    if($model->validate()) {

                        $user->attributes = $model->getAttributes(array(
                            'activationKey',
                            'status',
                            'lastpasswordchange',
                            'password',
                        ));

                        $user->userPassword = $model->password;

                        if($user->save()) {
                            MailHelper::sendCustomMail(Yii::app()->params['adminEmail'], $user->email, 'Change password', 'user_password_change_msg', array('model' => $user));
                            Yii::app()->user->setFlash('success', 'The new password has been saved.');
                            $this->redirect(Yii::app()->createUrl('site/login'));
                        }
                        $this->render('//registration/change_password', array('model' => $model));
                        Yii::app()->end();
                    }
                }
                $this->render('//registration/change_password', array('model' => $model));
            } else
                throw new CHttpException('404', 'The requested page does not exist.');
        } else
            throw new CHttpException('404', 'The requested page does not exist.');
    }

    public function actionAdmin()
    {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('admin', array('model'=>$model));

    }
    
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                    echo $error['message'];
            else
                    $this->render('error', $error);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=User::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

}
