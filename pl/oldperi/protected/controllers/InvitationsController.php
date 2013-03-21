<?php

class InvitationsController extends Controller {

        public $layout='//layouts/column1';

        public $experiment;

        public function filters()
        {
                return array(
                        'accessControl', // perform access control for CRUD operations
                );
        }

        public function accessRules() {
            return array(
                array('allow',
                    'actions'=>array('*'),
                    'roles' => array('manager', 'user', 'admin'),
                ),
                array('allow',
                    'actions'=>array('view'),
                    'roles' => array('guest'),
                ),
                array('deny',
                    'actions'=>array('*'),
                    'roles'=>array('guest'),
                ),
            );
        }


        public function actionView($token) {

                $invitation = Invitations::model()->find('"token"=:token', array(':token' => $token));

                if($invitation != NULL) {
                        if(Yii::app()->user->id != NULL) {
                                $grant = new AccessGrants;
                                $grant->level = $invitation->level;
                                $grant->user__id = Yii::app()->user->id;
                                $grant->experiment__id = $invitation->experiment__id;
                                if($grant->save()) {
                                        $invitation->invited__id = Yii::app()->user->id;
                                        $invitation->save();
                                        $this->redirect('/experiments/'<<$grant->experiment__id);
                                } else {
                                        //major error
                                        $this->render('error');
                                }
                        } else {
                            //No current user - they need to log in or create an account
                            $session = Yii::app()->getSession();
                            $session->add('invite_token', $token);
                            $this->render('log_in_or_create', array('session' => $session));
                        }
                } else {
                        //invitation was deleted. Tell them so.
                        $this->render('invitation_retracted');
                }
        }

        public function actionUpdate($id) {
                $model = Invitations::model()->findByPk($id);
                $this->experiment = $model->experiment;
		        if(isset($_POST['level'])) {
                        $model->level = $_POST['level'];
                        if($model->save()) {
                                if(Request::isAjax()) {
                                        $this->renderPartial('_update_js', array("model"=>$model));
                                } else {
                                        $this->redirect(Yii::app()->createUrl("accessGrants/index", array('id' => $model->experiment__id)));
                                }
                        } else {
                                //funnybusiness
                        }
                } else {
                        if(Request::isAjax()) {
                                $this->renderPartial('_edit_js', array('model'=>$model), false);
                        } else {
                                $this->render('update',array(
                                        'model'=>$model,
                                ));
                        }
                }
        }

        public function actionDelete($id) {
                $model = Invitations::model()->findByPk($id);
                if(Yii::app()->request->isPostRequest) {
                        $model->delete();
                        if(Request::isAjax()) {
                                $this->renderPartial('_delete_js', array("model" => $model));
                        } else {
                                $this->redirect(Yii::app()->createUrl("accessGrants/view", array('id' => $model->experiment__id)));
                        }
                } else {
                        $this->render('delete', array("model" => $model));
                }
        }
}
