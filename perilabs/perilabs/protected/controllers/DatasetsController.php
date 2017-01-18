<?php

class DatasetsController extends Controller
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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Datasets;
		$errors = array(); // For handling custom error messages

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Datasets']))
		{
			$model->attributes=$_POST['Datasets'];
			$model->result__id = $_REQUEST["result_id"];
			if($model->save()) {
				if(isset($_POST['metrics'])) {
					foreach($_POST['metrics'] as $metric_id => $metric_value):
						$metric = Metrics::model()->findByPk($metric_id);
						if($metric != null AND $metric->experiment__id == $model->result->trial->experiment__id) {
              $model_class_name = Yii::app()->params['data_type_storage'][$metric->dataType->data_type_id]['metric_class_name'];
              $data_model = new $model_class_name();
              $data_model->dataset__id = $model->dataset_id;
              $data_model->metric__id = $metric->metric_id;
              $data_model->value = $metric_value;
              if ($data_model->save()) {
                //all's good. next!
              } else {
                // problem - couldn't create variable.
                $errors[] = "The '$metric->title' metric couldn't be saved. Did you enter the value correctly?";

              }
						} else {
              // problem - metric doesn't exist, or the metric isn't part of this experiment. suspect funny business.
            }
					endforeach;
				}
			
				$this->redirect(array('/results/'.$model->result->result_id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
    $errors=array();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Datasets']))
		{
			$model->attributes=$_POST['Datasets'];
			if($model->save())
        if(isset($_POST['metrics'])) {
          $errors = array();
          foreach($_POST['metrics'] as $metric_id => $metric_value):
            $metric = Metrics::model()->findByPk($metric_id);
            if($metric != null AND $metric->experiment__id == $model->result->trial->experiment__id) {
              $model_class_name = Yii::app()->params['data_type_storage'][$metric->dataType->data_type_id]['metric_class_name'];
              $data_model = $model_class_name::model()->find('"dataset__id"=:dataset__id AND "metric__id"=:metric__id', array(":metric__id" => $metric->metric_id, ":dataset__id" => $model->dataset_id));
              if($data_model == NULL) {
                $data_model = new $model_class_name();
                $data_model->dataset__id = $model->dataset_id;
                $data_model->metric__id = $metric->metric_id;
              }
              $data_model->value = $metric_value;
              if ($data_model->save()) {
                //all's good. next!
              } else {
                // problem - couldn't create variable.
                $errors[] = "The '$metric->title' metric couldn't be saved. Did you enter the value correctly?";
              }
            } else {
              // problem - variable doesn't exist, or the variable isn't part of this experiment. suspect funny business.
            }
          endforeach;
        } else {
          // No variables associated with trial.
        }
        if(sizeof($errors) == 0) {
          $this->redirect(array('/results/'.$model->result->result_id));
        }
		}

		$this->render('update',array(
      'model'=>$model,
      'errors'=>$errors,
		));
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
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Datasets');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Datasets('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Datasets']))
			$model->attributes=$_GET['Datasets'];

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
		$model=Datasets::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='datasets-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
