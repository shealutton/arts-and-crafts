<?php
class MembershipsController extends Controller {
        public $layout='//layout/column1';

        public function filters()
        {
                return array(
                        'accessControl',
                );
        }

        public function accessRules() {
                return array(
                        array('allow',
                        'actions'=>array('create'),
                        'expression'=>'AccessControl::canShareOrganization($_GET["id"])',
                        ),
                        array('allow',
                        'actions'=>array('delete'),
                        'expression'=>'AccessControl::canDeleteMembership($_GET["id"])'
                        ),
                        array('deny',
                                'users' => array('*')
                        )
                );

        }

        public function loadModel($id)
        {
                $model = Memberships::model()->findByPk($id);
                if($model===null) {
                        throw new CHttpException(404, 'The requested page does not exist.');
                }
                return $model;
        }

        public function actionCreate()
        {
                $organization = Organizations::model()->findByPk($_GET["id"]);
                $user = User::model()->find('email=:email', array(":email" => $_REQUEST["email"]));

                if($user == NULL) {
                        $model = new Invitations();
                        $model->user__id = Yii::app()->user->id;
                        $model->level = $_REQUEST["level"];
                        $model->organization__id = $organization->organization_id;
                        $model->token = md5(uniqid());
                        $model->email_address = $_REQUEST["email"];

                        if($model->save()) {
                                error_log('invitation created');
                                MailHelper::sendCustomMail(Yii::app()->params['adminEmail'], $model->email_address, 'Invitation to collaborate', 'invitation_usr_msg', array('model' => $model));
                                if(Request::isAjax()) {
                                        $this->renderPartial("_create_invite_js", array("model" => $model));
                                } else {
                                        $this->redirect(array("/experiments/view", 'id' => $model->experiment__id));
                                }
                        } else {
                                $error = "Could not create invitation.";
                                if(Request::isAjax()) {
                                        $this->renderPartial("_create_error_js", array('errors' => $error));
                                } else {
                                        $this->render('create', array('errors'=>$error));
                                }
                        }
                } else {
                        $model = new Memberships();
                        $model->user__id = $user->id;
                        $model->organization__id = $organization->organization_id;
                        $model->level = $_REQUEST["level"];
                        error_log('email found-associating user');

                        if($model->save()) {
                            if(Request::isAjax()) {
                                $this->renderPartial("_create_js", array("model" => $model));
                            } else {
                                $this->redirect(array("/experiments/view", 'id' => $model->experiment__id));
                            }
                        } else {
                            // The user already has access to the project.
                            $error = "That user is already associated with this organization.";
                            if(Request::isAjax()) {
                                $this->renderPartial('_create_error_js', array('errors'=>$error));
                            } else {
                                $this->render('create', array('errors'=>$error));
                            }
                        }
                }
        }

        /* public function actionUpdate() { */
        /* } */

        public function actionDelete($id) {
                $model = $this->loadModel($id);

                $user_id = $model->user__id;
                if(Yii::app()->request->isPostRequest) {
                    $organization_id = $model->organization__id;
                    if($model->delete()) {

                        if(Request::isAjax()) {
                            $this->renderPartial('_delete_js', array("model" => $model));
                        } else {
                        }
                    }

                } else {
                        $this->render('delete', array("model" => $model));
                }
        }
}
