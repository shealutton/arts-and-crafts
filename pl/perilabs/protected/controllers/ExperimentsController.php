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
              'actions'=>array('view', 'chart', 'documentlist'),
              'expression'=>'AccessControl::canReadExperiment($_GET["id"])',
            ),
            array('allow',
              'actions'=>array('analyze'),
              'expression'=>'AccessControl::canReadExperiment($_GET["experiment_id"])',
            ), 
            array('allow',
              'actions'=>array('copy'),
              'expression'=>'AccessControl::canCopyExperiment($_GET["id"])',
            ),
            array('allow',
              'actions'=>array('update'),
              'expression'=>'AccessControl::canDesignExperiment($_GET["id"])',
            ),
            array('deny',
              'actions'=>array('update'),
              'expression'=>'!AccessControl::canDesignExperiment($_GET["id"])',
              'message'=>'You do not have the ability to change this experiment currently. If the experiment is locked, it must be unlocked before it can be edited.'
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
              'users'=>array('*'),
            ),
            array('deny',
              'users'=>array('*'),
              'message' => 'Access denied.'
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
            $organization = Organizations::model()->findByPk($_POST["Experiments"]["organization__id"]);
            $model->attributes=$_POST['Experiments'];

            if($organization->experimentsCount >= $organization->availableExperiments()) {
                    $model->addError('organization__id', "That organization already is using all of its available experiment slots. Please select a different organization or upgrade that organization's plan.");
            } else {
		    $model->user__id = Yii::app()->user->id;
                    if($model->save()) {
                            $access_grant = new AccessGrants;
                            $access_grant->level = "owner";
                            $access_grant->user__id = Yii::app()->user->id;
                            $access_grant->experiment__id = $model->experiment_id;
                            $access_grant->save();
                            $this->redirect(array('view','id'=>$model->experiment_id));
                    }
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
    
        if(!AccessControl::canUploadDocumentToExperiment($id)) {
                throw new CHttpException(403);
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
        if(move_uploaded_file($tempFile,$targetFile)) {
                echo 'OK';
        } else {
                $document->delete();
        }
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
        //if(Yii::app()->request->isPostRequest and $_POST['confirmation'] == "DELETE")
        if(Yii::app()->request->isPostRequest)
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
            $copyExp->user__id = Yii::app()->user->id;
            
            if($copyExp->save()) {
                if(isset($model->constants) && !empty($model->constants)) {
                    foreach($model->constants as $constant):
                    $model->copyExp($constant, $m = new Constants('copy'), array(
                        'experiment__id' => $copyExp->experiment_id
                    ));
                    endforeach;
                }
                if(isset($model->variables) && !empty($model->variables)) {
                    foreach($model->variables as $variable):
                    $model->copyExp($variable, $m = new Variables('copy'), array(
                        'experiment__id' => $copyExp->experiment_id
                    ));
                    endforeach;
                }

                if(isset($model->metrics) && !empty($model->metrics)) {
                    foreach($model->metrics as $metric):
                    $model->copyExp($metric, $m = new Metrics('copy'), array(
                        'experiment__id' => $copyExp->experiment_id
                    ));
                    endforeach;
                }
            // COPY TRIALS is not working right. Orphaned trials are being created with this code!
            // IF THE EXP IS UNLOCKED, NO TRIALS ANYWAY...
            //if(isset($model->trials) && !empty($model->trials)) {
                //    $model->copyExp($model->trials, $m = new Trials('copy'), array(
                //       'experiment__id' => $copyExp->experiment_id
                //    ));
                //}
                if(isset($model->accessGrants) && !empty($model->accessGrants)) {
                    foreach($model->accessGrants as $accessGrant):
                    $model->copyExp($accessGrant, $m = new AccessGrants('copy'), array(
                        'experiment__id' => $copyExp->experiment_id
                    ));
                    endforeach;
                }
                $this->redirect(array('experiments/update', 'id' => $copyExp->experiment_id, 'lastAction' => 'copy'));
            }
        }       
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
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
	function actionSearchEmptyResults() {
		$result = "No experiments were found that contain your search words.";
		$this->render('search1',array('result'=>$result));	
    }
     /**
     * experiemnts analyze function
     */
    public function actionAnalyze() {
        if(isset($_GET["experiment_id"])) {
                        $this->experiment = Experiments::model()->findByPk($_GET["experiment_id"]);
        }
        $this->render('analyze', array('model'=>$this->experiment));
    }

    public function actionChart() {
        
        if (isset($_POST['filter'])) {
                $filter=$_POST['filter'];

                //Get data from tables results and metrics for display results            
                $listData = $this->listTrialData($filter);
                echo CJSON::encode($listData);
        }
    }

    public function listTrialData($filter) {
            if($filter != NULL) {
                    $arr1= array();
                    
                    if($filter["Xaxis"] != "series") {
                            $X_metrics=Metrics::model()->findByPk($filter['Xaxis']);
                            $XaxisTitle=$X_metrics->title;
                            switch ($X_metrics->data_type__id) {
                            case 6:
                                    $arr1['XTimeType']="XAxis";
                            case 1:
                            case 2:
                            case 3:        //boolean
                                    $arr1['XAxisType']="ValueLabel";
                                    break;
                            case 4:
                                    $arr1['XAxisType']="Label";
                                    break;
                            }
                    } else {
                            $arr1['XAxisType']="ValueLabel";
                    }
                    if($filter["Yaxis"] != "series") {
                            $Y_metrics=Metrics::model()->findByPk($filter['Yaxis']);
                            $YaxisTitle=$Y_metrics->title;
                            switch ($Y_metrics->data_type__id) {
                            case 6:
                                    $arr1['YTimeType']="YAxis";
                            case 1:
                            case 2:
                            case 3:
                                    //real number (3)
                                    $arr1['YAxisType']="ValueLabel";
                                    break;
                            case 4:
                                    $arr1['YAxisType']="Label";
                                    break;                      
                            }
                    } else {
                            $arr1['YAxisType']="ValueLabel";
                    }


                    $stats=array();

                    foreach ($filter['Trials'] as $trial_id) {
                            $criteria = new CDbCriteria();
                            
                            //Get all results
                            
                           if(isset($trial_id))
                           {
                           		$trial_arr = Trials::model()->findByPk($trial_id);
                           		$trial_title = $trial_arr['title'];
                           }
                            
                            
                           if ($filter['ShowAll']=='true')
                           {
                             $criteria->condition = 'trial__id = :cond';
                             $criteria->params = array(':cond'=>$trial_id);
                             $criteria->order = 'result_id ASC';
                             
                             $results = Results::model()->findAll($criteria);     
                           }
                           else
                           {
                               $criteria->condition = 'trial__id = :cond';
                               $criteria->params = array(':cond'=>$trial_id);
                               
                               $row_count = Results::model()->count($criteria);
                               
                               if (intval($row_count)>2000)
                               {     
                                   $crt = new CDbCriteria();
                                   
                                   $crt->select = 'min(result_id) as min_resultid, max(result_id) as max_resultid';
                                   $crt->condition = 'trial__id = :cond';
                                   $crt->params = array(':cond'=>$trial_id); 
                                   
                                   $crt_result = Results::model()->find($crt);
                                   
                                   
                                   
                                   $criteria->condition = 'trial__id = :cond and result_id >= :min_resultid and result_id <= :max_resultid';
                                   $criteria->params = array(':cond'=>$trial_id,':min_resultid'=>$crt_result->min_resultid,':max_resultid'=>$crt_result->max_resultid);
                                   $criteria->order  = 'random(),result_id';
                                   $criteria->limit = 2000;
                                   
                                   $results=Results::model()->findAll($criteria);  
                                   usort($results,array($this,"SortRandomResult"));
                                   array_push($results,Results::model()->findByPk($crt_result->max_resultid));
                                   array_unshift($results,Results::model()->findByPk($crt_result->min_resultid));   
                                   
                               }
                               else
                               {
                                   
                                   $results = Results::model()->findAll($criteria);
                               }
                           }
                            $i=0;  
                            
                            foreach ($results as $result) {

                                    if(isset($Y_metrics)) {
                                            if ($Y_metrics->data_type__id==6) {
                                                    $temp_y= $this->microseconds($result->value_for_metric($Y_metrics));   
                                            } else {
                                                    if ($arr1['YAxisType']=="Label") {
                                                            $temp_y=$result->value_for_metric($Y_metrics);    
                                                    } else {
                                                            if ($Y_metrics->data_type__id==3)
                                                                    $temp_y=doubleval($result->value_for_metric($Y_metrics)); 
                                                            else
                                                                    $temp_y=intval($result->value_for_metric($Y_metrics)); 
                                                    }
                                            }
                                    } else {
                                            $temp_y = $i;
                                    }

                                    if(isset($X_metrics)) {
                                            if ($X_metrics->data_type__id==6) {
                                                    $temp_x= $this->microseconds($result->value_for_metric($X_metrics));   
                                            } else {
                                                    if ($arr1['XAxisType']=="Label") { 
                                                            $temp_x =$result->value_for_metric($X_metrics);
                                                    } else {
                                                            if ($X_metrics->data_type__id==3) {
                                                                    $temp_x =doubleval($result->value_for_metric($X_metrics));
                                                            } else {
                                                                    $temp_x =intval($result->value_for_metric($X_metrics));
                                                            }
                                                    }
                                            }
                                    } else {
                                            $temp_x = $i;
                                    }

                                    if ($arr1['XAxisType']=="ValueLabel" && $arr1['YAxisType']=="ValueLabel") {
                                    	   
                                            $arr1['Coord'][$trial_title][]=array($temp_x,$temp_y);    
                                    } else if ($arr1['XAxisType']=="Label" && $arr1['YAxisType']=="ValueLabel") {
                                            $arr1['XResults'][]=$temp_x;
                                            $arr1['Coord'][$trial_title][]=array($i,$temp_y);      
                                    } else if ($arr1['XAxisType']=="ValueLabel" && $arr1['YAxisType']=="Label") {
                                            $arr1['YResults'][]=$temp_y;
                                            $arr1['Coord'][$trial_title][]=array($temp_x,$i);    
                                    } else if ($arr1['XAxisType']=="Label" && $arr1['YAxisType']=="Label") {
                                            $arr1['Coord'][$trial_title][]=array($i,$i);    
                                    }

                                    $i++;  
                            }
                            
                    }     
                    if(!isset($XaxisTitle)) {
                            $XaxisTitle = 'Series';
                    }
                    if(!isset($YaxisTitle)) {
                            $YaxisTitle = 'Series';
                    }
                    return array(
                            'DataList'=>$arr1,
                            'ChartType'=>$filter['ChartType'],
                            'X_axis_Title'=>$XaxisTitle,
                            'Y_axis_Title'=>$YaxisTitle
                    );
            }
            return NULL;
    }
    static function SortRandomResult($a,$b)
    {
        if ($a->result_id == $b->result_id) {
           return 0;
        }
        return ($a->result_id < $b->result_id) ? -1 : 1;

    }
    public function microseconds($str) {
        
       $a = strptime(substr($str,0,19), '%Y-%m-%d %H:%M:%S');
       $b=intval(substr($str,20));
       $timestamp = mktime($a['tm_hour'], $a['tm_min'], $a['tm_sec'], $a['tm_mon']+1, $a['tm_mday'], $a['tm_year']+1900);
       return $timestamp*1000000+$b;
    }
}
