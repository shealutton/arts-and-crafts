<?php

class ExperimentsController extends Controller
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
              'actions'=>array('index', 'create', 'search'),
              'users' => array('@'),
            ),
            array('allow', 
              'actions'=>array('view', 'documentlist'),
              'expression'=>'AccessControl::canReadExperiment($_GET["id"])',
            ),
            array('allow',
              'actions'=>array('update'),
              'expression'=>'AccessControl::canDesignExperiment($_GET["id"])',
            ),
            array('allow',
              'actions'=>array('delete'),
              'expression'=>'AccessControl::canDeleteExperiment($_GET["id"])',
            ),
            array('allow',
              'actions'=>array('toggleLock'),
              'expression'=>'AccessControl::canLockExperiment($_GET["id"])',
            ),
            array('allow',
              'actions'=>array('upload'),
              'expression'=>'AccessControl::canUploadDocumentToExperiment($_GET["id"])',
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
            $this->experiment = $model;
            $this->render('view',array(
                'model'=>$model,
            ));
    }
    
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model=new Experiments;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Experiments']))
        {

            $model->attributes=$_POST['Experiments'];
            if($model->save()) {
                    $access_grant = new AccessGrants;
                    $access_grant->level = "owner";
                    $access_grant->user__id = Yii::app()->user->id;
                    $access_grant->experiment__id = $model->experiment_id;
                    $access_grant->save();
                    $this->redirect(array('view','id'=>$model->experiment_id));
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    public function actionTogglelock($id)
    {

            $model = $this->loadModel($id);
            $hasvariables = $model->variableCount > 0;
            $hasmetrics = $model->metricCount > 0;
            $hastrials = $model->trialCount > 0;
            $override = isset($_POST['override']) ? $_POST['override'] : false;
            if($model->locked) {
                if($hastrials and $override != 1) {
                        //notify that this may cause issues with existing trials
                        $this->render('experiment_has_trials');
                } else {
                        $model->locked = false;
                        $model->save();
                        $this->redirect(array('view', 'id'=>$model->experiment_id));
                }
            } elseif(!$model->locked) {
                   if(!$hasvariables or !$hasmetrics) {
                           //notify that you need variables or metrics
                           $this->redirect(array('view', 'id'=>$model->experiment_id));
                   } else {
                           $model->locked = true;
                           $model->save();
                           $this->redirect(array('view','id'=>$model->experiment_id));
                   }
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
            $this->experiment = $model;

            if(isset($_POST['Experiments']))
            {
                $model->attributes=$_POST['Experiments'];
                if($model->save()) {
                    $this->redirect(array('view','id'=>$model->experiment_id));
                }
            }

            $this->render('update',array(
                'model'=>$model,
            ));

    }

    public function actionUpload($id) {
    if(isset($_REQUEST['PHPSESSID'])){
        $session=Yii::app()->getSession();
        $session->close();
        $session->sessionID = $_REQUEST['PHPSESSID'];
        $session->open();
    }


        $model = $this->loadModel($id);
        $this->experiment = $model;
        $tempFile = $_FILES['Filedata']['tmp_name'];

        $document = new Documents;
        $document->file_name = $_FILES['Filedata']['name'];
        $document->experiment__id = $model->experiment_id;
        $document->user__id = Yii::app()->user->id;
        $document->filesize = filesize($tempFile);

        if (is_readable($tempFile)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $tempFile);
            finfo_close($finfo);
        } else {
            $mime_type = 'UNDETERMINED';
        }

        $document->mime = $mime_type;
        $document->save();

        $targetPath = Yii::getPathOfAlias('uploads') . '/experiments/'. $model->experiment_id .'/' . $document->document_id . '/';
        mkdir(str_replace('//','/',$targetPath), 0777, true);
        $targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
        move_uploaded_file($tempFile,$targetFile);
        echo 'OK';


}

    public function actionDocumentlist($id) {
        $model = $this->loadModel($id);
        $documents = $model->documents;
        $this->renderPartial('//documents/_list', array("documents" => $documents));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest and $_POST['confirmation'] == "DELETE")
        {
            // we only allow deletion via POST request
            $model = $this->loadModel($id);
            $parent_id = $model->parent_id;

            if($model != null) {
                if($model->delete()) {
                    //delete access to experiments
                    $access = AccessGrants::model()->findAll('experiment__id=:cond', array(':cond'=>$model->experiment_id));
                    foreach($access as $row) {
                        $row->delete();
                    }

                    //If exist child experiments, than change parent_id
                    $experiments = Experiments::model()->findAll(array(
                        'condition'=>'parent_id=:cond',
                        'params'=>array(':cond'=>$id),
                        'order'=>'experiment_id ASC',
                    ));

                    if($experiments != null) {
                        foreach($experiments as $exp) {
                            $exp->parent_id = $parent_id;
                            $exp->save();
                        }
                    }
                }
            }




            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else {
                        $model = $this->loadModel($id);
                        $this->experiment = $model;
                        $this->render('delete', array("model" => $model));
        }

    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //Find all active users in current organization
        //Find all experiments
        #$criteria = new CDbCriteria();

        /* if(Yii::app()->user->getShowFields() != null) { */
        /*     $exp = array(); */
        /*     foreach(Yii::app()->user->getShowFields() as $key =>$val) { */
        /*         foreach($val as $k=>$v) { */
        /*             if(Yii::app()->user->id == $k){ */
        /*                 $exp[] = $key; */
        /*             } */
        /*         } */
        /*     } */
        /*     $criteria->addInCondition('t.experiment_id', $exp); */
        /* } else { */
        /*     $criteria->with = array('user'); */
        /*     $criteria->condition = 'organization__id=:cond'; */
        /*     $criteria->params = array(':cond'=>Yii::app()->user->organization__id); */
        /* } */

        #$criteria->distinct = true;
        #$criteria->order = 't.date_created DESC';

        #$model = Experiments::model()->findAll($criteria);

        $this->render('index');  
    }
    /**
     * Copy experiment.
     */
    public function actionCopy()
    {
	    $id = Yii::app()->request->getParam('id');

        if($id) {
            $model = Experiments::model()->findByPk($id);
            
            $copyExp = new Experiments('copy');
            $copyExp->attributes = $model->getAttributes();
            $copyExp->parent_id = $model->experiment_id;
            $copyExp->locked = false;
            
            if($copyExp->save()) {

                if(isset($model->trials) && !empty($model->trials)) {
                    $model->copyExp($model->trials, $m = new Trials('copy'), array(
                       'experiment__id' => $copyExp->experiment_id
                    ));
                }
                if(isset($model->constants) && !empty($model->constants)) {
                    $model->copyExp($model->constants, $m = new Constants('copy'), array(
                        'experiment__id' => $copyExp->experiment_id
                    ));
                }
                if(isset($model->variables) && !empty($model->variables)) {
                    $model->copyExp($model->variables, $m = new Variables('copy'), array(
                        'experiment__id' => $copyExp->experiment_id
                    ));
                }
                if(isset($model->metrics) && !empty($model->metrics)) {
                    $model->copyExp($model->metrics, $m = new Metrics('copy'), array(
                        'experiment__id' => $copyExp->experiment_id
                    ));
                }
                if(isset($model->accessGrants) && !empty($model->accessGrants)) {
                    $model->copyExp($model->accessGrants, $m = new AccessGrants('copy'), array(
                        'experiment__id' => $copyExp->experiment_id
                    ));
                }
                $this->redirect(array('index'));
            }
        }       
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        /*$model->unsetAttributes();  // clear any default values
        if(isset($_GET['Experiments']))
            $model->attributes=$_GET['Experiments'];

        $this->render('admin',array(
            'model'=>$model,
        ));*/
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=Experiments::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='experiments-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
	
	  /**
     * search function
     */
    public function actionSearch()
    {
		$model=new SearchForm;
			// collect search input data
		 if(isset($_POST['SearchForm']))
        {
			$model->attributes=$_POST['SearchForm'];
            $text = $_POST['SearchForm']['search_txt'];
			$result = $model->search($text);
			$experimentIds = array();
			foreach($result as $row)
			{
				$experimentId1 = $row['experiment_id'];
				$experimentIds[] = $experimentId1;
			}
			/* condition to check if experimentid exist or not*/
			/*if condition start */
			if(!empty($experimentIds))
			{
			$experimentIdString = implode(",",$experimentIds);
			$check = "experiment_id IN ($experimentIdString)";
			$dataProvider=new CActiveDataProvider('Experiments', array(
				'criteria' => array(
				  'distinct' => true,
				  'join'=>'LEFT JOIN access_grants ON t.experiment_id=access_grants.experiment__id',
				  'condition'=> $check ,
				  'order'=>'date_created DESC',
				)
			  )
			);
			   $this->render('search',array(
			  'dataProvider'=>$dataProvider,
			));
		}
			/*if end 
			else start
			*/
			else
			{	

				$this->actionSearchEmptyResults();
			}
			/* 
			else end
			*/
		}
             
    }
	/* No search result function */
	function actionSearchEmptyResults()
	{
		$result = "No experiments were found that contain your search words.";
		$this->render('search1',array('result'=>$result));	
    }
     /**
     * experiemnts analyze function
     */
    public function actionAnalyze()
    {
        if(isset($_GET["experiment_id"])) {
                        $this->experiment = Experiments::model()->findByPk($_GET["experiment_id"]);
        }
        $this->render('analyze');
    }
}
