<?php
class AccessGrantsController extends Controller {

        public $layout='//layouts/column1';

        public function filters()
        {
                return array(
                        'accessControl', // perform access control for CRUD operations
                );
        }

    public function accessRules() {
        return array(
            array('allow',
              'actions'=>array('view'),
              'expression' => 'AccessControl::canReadExperiment($_GET["id"])', 
            ),
            array('allow',
              'actions' => array('create'),
              'expression' => 'AccessControl::canShareExperiment($_GET["id"])',
            ),
            array('deny',
              'actions'=>array('view', 'create'),
              'expression' => '!AccessControl::canShareExperiment($_GET["id"])',
              'message' => "You are not authorized to share this experiment. To share experiments, you must be the experiment's owner or the manager of the organization.",
            ),
            array('allow',
              'actions' => array('update'),
              'expression' => 'AccessControl::canWriteAccessGrant($_GET["id"])',
            ),
            array('allow',
              'actions' => array('delete'),
              'expression' => 'AccessControl::canDeleteAccessGrant($_GET["id"])',
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
        public $experiment;

        public function loadModel($id)
        {
            $model=AccessGrants::model()->findByPk($id);
            if($model===null)
                    throw new CHttpException(404,'The requested page does not exist.');
            return $model;
        }

        public function actionView($id)
        {
                $experiment = Experiments::model()->findByPk($id);
                $this->experiment = $experiment;
                $accessgrants = $this->experiment->accessGrants;
                $invitations = Invitations::model()->findAllByAttributes(array('experiment__id' => $experiment->experiment_id));
                $this->render('view', array("accessgrants" => $accessgrants, 'invitations' => $invitations, "experiment" => $experiment));
        }

        public function actionCreate()
        {
                $experiment = Experiments::model()->findByPk($_GET["id"]);
                $this->experiment = $experiment;


                    $user = User::model()->find('email=:email', array(":email" => $_REQUEST["email"]));

                    if($user == NULL) {

                        # Create an invitation
                        $model = new Invitations;
                        $model->user__id = Yii::app()->user->id;
                        $model->level = $_REQUEST['level'];
                        $model->experiment__id = $experiment->experiment_id;
                        $model->token = md5(uniqid());
                        $model->email_address = $_REQUEST["email"];

                        if($model->save()) {
                            MailHelper::sendCustomMail(Yii::app()->params['adminEmail'], $model->email_address, 'Invited to collaborate', 'invitation_usr_msg', array('model' => $model));
                            if(Request::isAjax()) {
                                $this->renderPartial("_create_invite_js", array("model" => $model));
                            } else {
                                $this->redirect(array("/experiments/view", 'id' => $model->experiment__id));
                           }

                        } else {
                            // The user already has access to the project.
                            $error = "That user is already associated with this project.";
                            if(Request::isAjax()) {
                                $this->renderPartial('_create_error_js', array('errors'=>$error));
                            } else {
                                $this->render('create', array('errors'=>$error));
                            }
                        }
                    }elseif($user != NULL) {
                        $model = new AccessGrants;
                        $model->user__id = $user->id;
                        $model->experiment__id = $experiment->experiment_id;
                        $model->level = $_REQUEST['level'];
                        if($model->save()) {
                            if(Request::isAjax()) {
                                $this->renderPartial("_create_js", array("model" => $model));
                            } else {
                                $this->redirect(array("/experiments/view", 'id' => $model->experiment__id));
                            }
                        } else {
                            // The user already has access to the project.
                            $error = "That user is already associated with this project.";
                            if(Request::isAjax()) {
                                $this->renderPartial('_create_error_js', array('errors'=>$error));
                            } else {
                                $this->render('create', array('errors'=>$error));
                            }
                        }
                } else {
                    if(Request::isAjax()) {
                    } else {
                        $this->render('create', array("errors"=>NULL, "experiment" => $experiment));
                    }
                }
        }

        public function actionUpdate($id) {
                $model = $this->loadModel($id);
                $this->experiment = $model->experiment;
                $user = User::model()->findByPk($model->user__id);
                if(isset($_POST["level"])) {
                        $model->level = $_POST['level'];
                        if($model->save()){
                                if(Request::isAjax()) {
                                        $this->renderPartial('_update_js', array("model"=>$model));
                                } else {
                                        $this->redirect(array('experiments/index','id'=>$model->experiment__id));
                                }
                        } else {
                                // funnybusiness
                        }
                } else {
                        if(Request::isAjax()) {
                                $this->renderPartial('_edit_js', array("model"=>$model, "user"=>$user));
                        } else {
                                $this->render('update', array("model"=>$model, "user"=>$user));
                        }
                }
        }

        public function actionDelete($id) {
                $model = $this->loadModel($id);
                $this->experiment = $model->experiment;
                $user_id = $model->user__id;
                if(Yii::app()->request->isPostRequest) {
                    $experiment_id = $model->experiment__id;
                    if($model->delete()) {
                        $invitation = Invitations::model()->find('invited__id =:invited AND experiment__id =:experiment', array(':invited'=>$user_id, ':experiment'=>$experiment_id));
                        if($invitation)
                            $invitation->delete();

                        if(Request::isAjax()) {
                            $this->renderPartial('_delete_js', array("model" => $model));
                        } else {
                            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array("/experiments/index", 'id' => $experiment_id));
                        }
                    }

                } else {
                        $this->render('delete', array("model" => $model));
                }
        }

        public function sendInvitationEmail($model) {
            MailHelper::sendCustomMail(Yii::app()->params['adminEmail'], $model->email_address, 'Invited to collaborate', 'invitation_usr_msg', array('model' => $model));
        }

}
