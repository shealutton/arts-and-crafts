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
                    'actions'=>array('update'),
                    'expression'=>'AccessControl::canWriteInvitation($_GET["id"])',
                ),
                array('allow',
                    'actions'=>array('delete'),
                    'expression'=>'AccessControl::canDeleteInvitation($_GET["id"])'
                ),
                array('allow',
                    'actions'=>array('view'),
                    'users' => array('*'),
                ),
                array('deny',
                    'users' => array('*'),
                ),
            );
        }


        public function actionView($token) {

                $invitation = Invitations::model()->find('"token"=:token', array(':token' => $token));

                if($invitation != NULL and $invitation->invited__id == NULL) {
                        if(Yii::app()->user->id != NULL) {
                                if($invitation->experiment__id != NULL) {
                                        $grant = new AccessGrants;
                                        $grant->level = $invitation->level;
                                        $grant->user__id = Yii::app()->user->id;
                                        $grant->experiment__id = $invitation->experiment__id;
                                        if($grant->save()) {
                                                $invitation->invited__id = Yii::app()->user->id;
                                                $invitation->save();
                                                $this->redirect(Yii::app()->createUrl('experiments/view', array('id' => $grant->experiment__id)));
                                        } else {
                                                //major error
                                                $this->render('error');
                                        }
                                }
                                if($invitation->organization__id != NULL) {
                                        $membership = Memberships::model()->find('organization__id=:organization_id and user__id=:user_id',
                                                array(
                                                        ':organization_id' => $invitation->organization__id,
                                                        ':user_id' => Yii::app()->user->id,
                                                )
                                        );
                                        if($membership != null) {
                                                if($membership->level == 'member') {
                                                        $membership->level = $invitation->level;
                                                }
                                                if($membership->save()) {
                                                        $invitation->invited__id = Yii::app()->user->id;
                                                        $invitation->save();
                                                        $this->redirect(Yii::app()->createUrl('experiments/index'));
                                                } else {
                                                        $this->render('error');
                                                }

                                        } else {
                                                $membership = new Memberships();
                                                $membership->organization__id = $invitation->organization__id;
                                                $membership->user__id = Yii::app()->user->id;
                                                $membership->level = $invitation->level;
                                                if($membership->save()) {
                                                        $invitation->invited__id = Yii::app()->user->id;
                                                        $invitation->save();
                                                        $this->redirect(Yii::app()->createUrl('experiments/index'));
                                                } else {
                                                        //major error
                                                        $this->render('error');
                                                }
                                        }
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
