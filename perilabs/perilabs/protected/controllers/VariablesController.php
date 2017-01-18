<?php

class VariablesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('view'),
                'expression' => 'AccessControl::canReadVariable($_GET["id"])'
            ),
            array('allow',
                'actions'=>array('update'),
                'expression'=>'AccessControl::canWriteVariable($_GET["id"])'
            ),
            array('allow',
                'actions'=>array('delete'),
                'expression'=>'AccessControl::canDeleteVariable($_GET["id"])'
            ),
            array('allow',
                'actions'=>array('create'),
                'expression'=>'AccessControl::canDesignExperiment(isset($_REQUEST["experiment_id"]) ? $_REQUEST["experiment_id"] : null)'
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

        public $experiment;

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $model = $this->loadModel($id);
            $this->render('view',array(
                'model'=> $model,
            ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
            $model=new Variables;
            $this->experiment = Experiments::model()->findByPk($_GET["experiment_id"]);

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['Variables']))
            {
                    $model->attributes=$_POST['Variables'];
                    $model->experiment__id=$_REQUEST['experiment_id'];
                    $should_save = true;

                    // sane defaults for integers and reals
                    if($model->data_type__id == 2 or $model->data_type__id == 3) {
                            if($model->increment == NULL) {
                                    $model->increment = 1;
                            }
                            if($model->min == NULL or $model->max == NULL) {
                                    $should_save = false;
                            }
                    }

                    if($should_save and $model->save()) {
                            if($model->data_type__id == 4) {
                                  $this->attachVariablesText($model);
                            }
                            if($model->data_type__id == 6) {
                                  $this->attachVariablesTime($model);
                            }
                            if(Request::isAjax()) {
                                    $this->renderPartial('_create_js', array('model' => $model), false);
                            } else {
                                    if (isset($_POST['Variables']['return_to_experiment']) && $_POST['Variables']['return_to_experiment'] && isset($_GET['experiment_id']) && is_numeric($_GET['experiment_id'])) {
                                            $this->redirect(Yii::app()->request->baseUrl . '/experiments/' . $model->experiment__id);
                                    } else {
                                            $this->redirect(array('view','id'=>$model->variable_id));
                                    }
                            }
                    } else {
                            if(Request::isAjax()) {

                            } else {
                                    $this->render('create',array(
                                            'model'=>$model,
                                    ));
                            }
                    }
            } else {
                    $this->render('create',array(
                            'model'=>$model,
                    ));
            }
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

        $model=$this->loadModel($id);
            $this->experiment = $model->experiment;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['Variables']))
            {
                  $model->attributes=$_POST['Variables'];
                  $should_save = true;

                  // sane defaults for integers and reals
                  if($model->data_type__id == 2 or $model->data_type__id == 3) {
                          if($model->increment == NULL) {
                                  $model->increment = 1;
                          }
                          if($model->min == NULL or $model->max == NULL) {
                                  $should_save = false;
                          }
                  }
                  if($model->data_type__id == 4) {
                          $this->attachVariablesText($model);
                  }
                  if($model->data_type__id == 6) {
                          $this->attachVariablesTime($model);
                  }


                  if($should_save and $model->save()) {
                    if(Request::isAjax()) {
                      $this->renderPartial('_update_js', array("model"=>$model), false);
                    } else {
                      $this->redirect(array('view','id'=>$model->variable_id));
                    }
                  } else {
                    if(Request::isAjax()) {
                      //do nothing
                    } else {
                      $this->render('update',array(
                        'model'=>$model,
                      ));
                    }
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
                    $experiment_id = $model->experiment__id;
                    $model->delete();

                    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                    if(Request::isAjax()) {
                                    $this->renderPartial('_delete_js', array("model"=>$model));
                                  } else {
                                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array("experiments/view/$experiment_id"));
                                  }
            } else {
                    $model = $this->loadModel($id);
                    $this->experiment = $model->experiment;
                    $this->render("delete", array("model" => $model));
            }

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Variables');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Variables('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Variables']))
			$model->attributes=$_GET['Variables'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Variables::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='variables-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

        public function attachVariablesText($model)
        {
                //save VariablesTexts
                $variableTexts = $_REQUEST['VariablesText'];
                foreach($variableTexts as $key => $value):
                        if($value != null) {
                                $txt = VariablesText::model()->findByPk($key);
                                if($txt == null) {
                                        $txt = new VariablesText();
                                        $txt->variable__id = $model->variable_id;
                                } elseif($txt->variable__id != $model->variable_id) {
                                        $txt = new VariablesText();
                                        $txt->variable__id = $model->variable_id;
                                } 
                                $txt->value = $value;
                                $txt->save();
                        } else {
                                $txt = VariablesText::model()->findByPk($key);
                                if($txt != null and $txt->variable__id == $model->variable_id) {
                                        $txt->delete();
                                }
                        }
                endforeach;
        }

        public function attachVariablesTime($model) {
                //save VariablesTime
                $variableTimes = $_REQUEST['VariablesTimestamp'];
                foreach($variableTimes as $key => $value):
                        if($value != null) {
                                $time = VariablesTime::model()->findByPk($key);
                                if($time == null) {
                                        $time = new VariablesTime();
                                        $time->variable__id = $model->variable_id;
                                } elseif($time->variable__id != $model->variable_id) {
                                        $time = new VariablesTime();
                                        $time->variable__id = $model->variable_id;
                                } 
                                $time->value = $value;
                                $time->save();
                        } else {
                                $time = VariablesTime::model()->findByPk($key);
                                if($time != null and $txt->variable__id == $model->variable_id) {
                                        $time->delete();
                                }
                        }
                endforeach;
        }
}
