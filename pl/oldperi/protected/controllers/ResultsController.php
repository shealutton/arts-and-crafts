<?php

class ResultsController extends Controller
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
                'actions'=>array('create'),
                'expression' => 'AccessControl::canWriteTrial(isset($_REQUEST["trial_id"]) ? $_REQUEST["trial_id"] : null)',
            ),
            array('allow',
                'actions'=>array('update'),
                'expression' => 'AccessControl::canWriteResult($_GET["id"])',
            ),
            array('allow',
                'actions'=>array('delete'),
                'expression' => 'AccessControl::canDeleteResult($_GET["id"])'
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
                $experiment = $this->trial->experiment;
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
		$model=new Results;
        $trial = Trials::model()->findByPk($_REQUEST["trial_id"]);
        $this->experiment = $trial->experiment;
                
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['Results']))
            {
                $model->attributes=$_POST['Results'];
                            $model->trial__id=$_REQUEST['trial_id'];
                if($model->save()) {
                                    if(isset($_POST["metrics"])) {
                                            $model->buildMetrics($_POST["metrics"]);
                                    }
                                    if(Request::isAjax()) {
                                            $this->renderPartial('_create_js', array("model"=>$model, "experiment_id"=>$this->experiment->experiment_id), false);
                                    } else {
                                            $this->redirect(array('trials/view','id'=>$model->trial__id));
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
        $trial = $model->trial;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
            if(isset($_POST['Results']))
            {
                $model->attributes=$_POST['Results'];
                if($model->save()) {
                                    if(isset($_POST['metrics'])) {
                                            $model->buildMetrics($_POST['metrics']);
                                    }
                                    if(Request::isAjax()) {
                                            $this->renderPartial('_update_js', array('model'=>$model, 'trial'=>$model->trial), false);
                                    } else {
                                            $this->redirect(array('//trials/view','id'=>$model->trial->trial_id));
                                    }
                            } else {
                                   //handle error
                            }
            } else {
                            if(Request::isAjax()) {
                                    $this->renderPartial('_edit_js', array('model'=>$model, 'trial'=>$model->trial), false);
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
		if(Yii::app()->request->isPostRequest and $_POST["confirmation"] == "DELETE") {
			// we only allow deletion via POST request
            $model = $this->loadModel($id);
                $trial_id = $model->trial__id;
                $model->delete();

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                            if(Request::isAjax()) {
                                    $this->renderPartial("_delete_js", array("model"=>$model));
                            } else {
                                    $this->redirect(array("trials/view", "id" => $trial_id));
                            }
		} else {
                        $model = $this->loadModel($id);
                        $this->render("delete", array("model" => $model));
                }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Results');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Results('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Results']))
			$model->attributes=$_GET['Results'];

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
		$model=Results::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='results-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
