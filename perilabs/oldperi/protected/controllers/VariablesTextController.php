<?php

class VariablesTextController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('destroy'),
				'users'=>array('@'),
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
                $model=new VariablesText;

                // Uncomment the following line if AJAX validation is needed
                // $this->performAjaxValidation($model);

                if(isset($_POST['VariablesText']))
                {
                        $model->attributes=$_POST['VariablesText'];

                        if($model->save()) {
                            if(Request::isAjax()) {
                                $this->renderPartial('_create_js', array('model' => $model), false);
                            } else {
                                //FIXME: non-AJAX saves should redirect to experiment
                                $this->redirect(array('view','id'=>$model->var_text_id));
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
		//$this->experiment = $model->variable->experiment;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VariablesText']))
		{
			$model->attributes=$_POST['VariablesText'];
            if($model->save()) {
                if(Request::isAjax()) {
                    $this->renderPartial('_update_js', array("model"=>$model), false);
                } else {
                    $this->redirect(array('view','id'=>$model->variable_id));
                }
            }
        } else {
            if(Request::isAjax()) {
                $this->renderPartial('_edit_js', array('model'=>$model, 'variable_id'=>$model->variable__id), false);
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
                $experiment_id = $model->variable->experiment__id;
                $model->delete();
                    if(Request::isAjax()) {
                        $this->renderPartial('_delete_js', array("model"=>$model));
                    } else {
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array("experiments/view/$experiment_id"));
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
		$dataProvider=new CActiveDataProvider('VariablesText');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new VariablesText('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VariablesText']))
			$model->attributes=$_GET['VariablesText'];

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
		$model=VariablesText::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='variables-text-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
