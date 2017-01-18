<?php

class TrialsController extends Controller
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
                        'actions'=>array('view', 'documentlist', 'resultlist', 'template', 'listTrialData'),
                        'expression'=>'AccessControl::canReadTrial($_GET["id"])'
                      ),
                      array('allow',
                        'actions'=>array('create'),
                        'expression'=>'AccessControl::canGatherExperiment(isset($_REQUEST["experiment_id"]) ? $_REQUEST["experiment_id"] : null)',
                      ),
                      array('allow',
                        'actions'=>array('update'), //We're not allowing deletion of trials, so this has been removed.
                        'expression'=>'AccessControl::canWriteTrial($_GET["id"])',//'AccessControl::canEditTrial($_GET["id"]))',
                      ),
                      array('allow',
                        'actions'=>array('upload'),
                        'expression'=>'AccessControl::canWriteTrial($_GET["id"])',
                      ),
            array('deny',  // deny all users
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
            $this->experiment = $model->experiment;

            //Get data from tables results and metrics for display results
            $listData = $this->listTrialData($model->trial_id, $model->experiment__id);

            $this->render('view',array(
                'model'=> $model,
                'listData'=>$listData
            ));
    }

    public function actionTemplate($id)
    {
        $model = $this->loadModel($id);
        $this->experiment = $model->experiment;
        $type = isset($_GET['type']) ? $_GET['type'] : NULL;
        if($type == 'csv') {
                header('Content-Type: application/csv');
                header("Content-Disposition: attachment; filename={$model->title}.{$model->experiment->title}.csv");
                $this->renderPartial('csv', array(
                    'model'=> $model
                ));
        } else {
                header('Content-Type: application/vnd.ms-excel');
                header("Content-Disposition: attachment; filename={$model->title}.{$model->experiment->title}.xls");
                $this->renderPartial('xls', array(
                        'model' => $model
                ));
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
            $model=new Trials;
            $errors = array(); // For handling custom error messages
            $this->experiment = Experiments::model()->findByPk($_GET['experiment_id']);
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['Trials']))
            {
                  $model->attributes=$_POST['Trials'];
                  $model->experiment__id = $_REQUEST["experiment_id"];
                  if($model->save()) {
                    if(isset($_POST['variables'])) {
                      foreach($_POST['variables'] as $variable_id => $variable_value):
                        $variable = Variables::model()->findByPk($variable_id);
                        if($variable != null AND $variable->experiment__id == $model->experiment__id) {
                          $model_class_name = Yii::app()->params['data_type_storage'][$variable->dataType->data_type_id]['variable_class_name'];
                          $data_model = new $model_class_name();
                          $data_model->trial__id = $model->trial_id;
                          $data_model->variable__id = $variable->variable_id;
                          $data_model->value = $variable_value;
                          if ($data_model->save()) {
                            //all's good. next!
                          } else {
                            // problem - couldn't create variable.
                            $errors[] = "The '$variable->title' variable couldn't be saved. Did you enter the value correctly?";

                          }
                        } else {
                          // problem - variable doesn't exist, or the variable isn't part of this experiment. suspect funny business.
                        }
                      endforeach;
                    } else {
                      // No variables associated with trial.
                    }
                    if(sizeof($errors) == 0) {
                      $this->redirect(array('view','id'=>$model->trial_id));
                    } else {
                      $this->render('update',array(
                        'model'=>$model,
                        'errors'=>$errors,
                      ));
                    }
                  }
            }

            $this->render('create',array(
                'model'=>$model,
            ));
    }
	
	/**
     * Get data from tables results and metrics for show it on page.
     * @param integer $trial_id
	 * @param integer $experiment__id
	 * return array() or NULL
     */
	public function listTrialData($trial_id = NULL, $experiment__id = NULL)
	{
		if($trial_id != NULL && $experiment__id != NULL) {
			
			// items on page
			$page_size = 200;
		
			$criteria = new CDbCriteria();
			$criteria->condition = 'trial__id = :cond';
			$criteria->params = array (':cond'=>$trial_id);
			$criteria->order = 'result_id ASC';
			
			//Get count rows
			$row_count = Results::model()->count($criteria);
			
			//Create pagination 
			$pages = new CPagination($row_count);
			$pages->setPageSize($page_size);
			$pages->applyLimit($criteria);
			
			//Get all results
			$results = Results::model()->findAll($criteria);
			
			//Get experiment
			$criteria = new CDbCriteria();
			$criteria->condition = 'experiment_id = :cond';
			$criteria->params = array (':cond'=>$experiment__id);
			
			$exp = Experiments::model()->find($criteria);
			
			//Get metrics
			if($exp != NULL) {
				$criteria = new CDbCriteria();
				$criteria->condition = 'experiment__id = :cond';
				$criteria->params = array (':cond'=>$exp->experiment_id);
				
				$metrics = Metrics::model()->findAll($criteria);
			} else {
				$metrics = NULL;
			}
			
			return array('results'=>$results, 'metrics'=>$metrics, 'row_count'=>$row_count, 'page_size' => $page_size, 'pages'=>$pages);
		}
			return NULL;
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
            $this->experiment = $model->experiment;
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['Trials']))
            {
                $model->attributes=$_POST['Trials'];
                if($model->save())
            if(isset($_POST['variables'])) {
              $errors = array();
              foreach($_POST['variables'] as $variable_id => $variable_value):
                $variable = Variables::model()->findByPk($variable_id);
                if($variable != null AND $variable->experiment__id == $model->experiment__id) {
                  $model_class_name = Yii::app()->params['data_type_storage'][$variable->dataType->data_type_id]['variable_class_name'];
                  $data_model = $model_class_name::model()->find('"variable__id"=:variable_id AND "trial__id"=:trial_id', array(":variable_id" => $variable->variable_id, ":trial_id" => $model->trial_id));
                  if($data_model == NULL) {
                    $data_model = new $model_class_name();
                    $data_model->trial__id = $model->trial_id;
                    $data_model->variable__id = $variable->variable_id;
                  }
                  $data_model->value = $variable_value;
                  if ($data_model->save()) {
                    //all's good. next!
                  } else {
                    // problem - couldn't create variable.
                    $errors[] = "The '$variable->title' variable couldn't be saved. Did you enter the value correctly?";
                  }
                } else {
                  // problem - variable doesn't exist, or the variable isn't part of this experiment. suspect funny business.
                }
              endforeach;
            } else {
              // No variables associated with trial.
            }
            if(sizeof($errors) == 0) {
              $this->redirect(array('view','id'=>$model->trial_id));
            }
            }

            $this->render('update',array(
          'model'=>$model,
          'errors'=>$errors,
            ));
    }

        

        public function actionUpload($id)
        {
            if(isset($_REQUEST['PHPSESSID'])){
                $session=Yii::app()->getSession();
                $session->close();
                $session->sessionID = $_REQUEST['PHPSESSID'];
                $session->open();
            }
            

            $model = $this->loadModel($id);
                $this->experiment = $model->experiment;
                $tempFile = $_FILES['Filedata']['tmp_name'];

                $document = new Documents;
                $document->file_name = $_FILES['Filedata']['name'];
                $document->trial__id = $model->trial_id;
                $document->user__id = Yii::app()->user->id;
                $document->filesize = filesize($tempFile);

                if (is_readable($tempFile)) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime_type = finfo_file($finfo, $tempFile);
                    finfo_close($finfo);
                } else {
                    $mime_type = 'UNDETERMINED';
                }
                error_log($mime_type);

                $document->mime = $mime_type;
                $document->save();

                $targetPath = Yii::getPathOfAlias('uploads') . '/trials/'. $model->trial_id .'/' . $document->document_id . '/';
                mkdir(str_replace('//','/',$targetPath), 0777, true);
                $targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
                move_uploaded_file($tempFile,$targetFile);
                echo 'OK';

                //parse the file if that's specified by the request
                $parse = isset($_GET['parse']);
                if($parse) {
                        $document->parse();
                }
        }

        public function actionDocumentlist($id) {
                $model = $this->loadModel($id);
                $documents = $model->documents;
                $this->renderPartial('//documents/_list', array("documents" => $documents));
        }

        public function actionResultlist($id) {
                $model = $this->loadModel($id);
                $this->renderPartial('_result_list', array("model" => $model));
        }




    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest and $_POST["confirmation"] == "DELETE")
        {
            // we only allow deletion via POST request
            $model = $this->loadModel($id);
                $experiment_id = $model->experiment__id;
                $model->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : Yii::app()->baseUrl."/experiments/$experiment_id");

        }
        else
            {
                    $model = $this->loadModel($id);
                    $this->experiment = $model->experiment;
                    $this->render('delete', array("model" => $model));
            }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('Trials');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Trials('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Trials']))
            $model->attributes=$_GET['Trials'];

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
        $model=Trials::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='trials-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
