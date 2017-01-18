<?php

class DocumentsController extends Controller
{
    public $layout='//layouts/column1';

    public function filters() {
            return array(
                    'accessControl',
            );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions'=>array('view'),
                'expression' => 'AccessControl::canReadDocument($_GET["id"])',
            ),
            array('allow',
                'actions'=>array('delete'),
                'expression'=>'AccessControl::canDeleteDocument($_GET["id"])',
            ),
            array('allow',
                'actions'=>array('update'),
                'expresion'=>'AccessControl::canWriteDocument($_GET["id"])',
            ),
            array('allow',
                'actions'=>array('create'),
                'users'=>array('@')
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public $experiment;

    public function actionView($id)
    {
        $model = $this->loadModel($id);
            if ($model->experiment__id == null) {
                $attached_to = "trials";
                $target_id = $model->trial__id;
                $experiment_obj = $model->trial->experiment;
                $trial_obj = $model->trial;
            } else {
                $attached_to = "experiments";
                $target_id = $model->experiment__id;
                $experiment_obj = $model->experiment;
                $trial_obj = false;
            }
            $targetPath = Yii::getPathOfAlias('uploads') . '/' . $attached_to.'/'. $target_id .'/' . $model->document_id . '/';

            // If we have a handler mapped to this mime type...
            /* if ( isset(Yii::app()->params['handlers']['documents']['view'][$model->mime]) ){ */
            /*     $this->render('view',array( */
            /*         'model'=> $model, */
            /*         'experiment'=>$experiment_obj, */
            /*         'trial'=>$trial_obj, */
            /*         'path'=> $targetPath.$model->file_name, */
            /*         'attached_to'=> $attached_to, */
            /*         'handler'=>Yii::app()->params['handlers']['documents']['view'][$model->mime], */
            /*     )); */
            /* } else { // Otherwise, assume it's a downloadable attachment */

            //for now, we're just going to download everything.
            $request = Yii::app()->request;
            error_log($targetPath.$model->file_name);
            $request->xSendFile($targetPath.$model->file_name);#, array());
            /* } */
    }

  /**
   * Creates a new model.
   * If creation is successful, the browser will redirected to the 'view' page.
   */
  public function actionCreate()
  {

        $model=new Documents;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_REQUEST['PHPSESSID'])){
            $session=Yii::app()->getSession();
            $session->close();
            $session->sessionID = $_REQUEST['PHPSESSID'];
            $session->open();
        }

        if(isset($_POST['Documents']))
        {
            $model->attributes=$_POST['Documents'];

            if (isset($_POST['Documents']['experiment__id'])) $model->experiment__id = $_POST['Documents']['experiment__id'];
            if (isset($_POST['Documents']['trial__id'])) $model->trial__id = $_POST['Documents']['trial__id'];

            $model->user__id = Yii::app()->user->id;
            $model->mime = 'text/html';
            if ($model->experiment__id == null) {
                $attached_to = "trials";
                $target_id = $model->trial__id;
            } else {
                $attached_to = "experiments";
                $target_id = $model->experiment__id;
            }
            $model->filesize = 0; //Won't know actual size until it's written

            $outputPath = Yii::getPathOfAlias('uploads').'/' .$attached_to.'/'. $target_id .'/' . $model->document_id . '/' . $model->file_name;

            $targetPath = Yii::getPathOfAlias('uploads').'/' . $attached_to.'/'. $target_id .'/' . $model->document_id . '/';
            error_log("Attempting to create directory at: ".str_replace('//','/',$targetPath)."");

            if(!is_dir(str_replace('//','/',$targetPath))) {
                mkdir(str_replace('//','/',$targetPath), 0777, true);
            }

            $targetFile =  str_replace('//','/',$targetPath) . $model->file_name;

            $filesize = file_put_contents($targetFile, $model->body);
            $model->filesize = $filesize;
/*
            //echo "<p>Body: " . $_POST['Documents']['body'] ."</p>";
            //echo "<p>Experiment ID: " . $model->experiment__id ."</p>";
            //echo "<pre>\n\n";
            //var_dump($model->attributes);
            //echo "</pre>\n\n";

            $model->file_name = $_FILES['Filedata']['name'];

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

            $targetPath = Yii::getPathOfAlias('webroot') . '/uploads/experiments/'. $model->experiment_id .'/' . $document->document_id . '/';
            mkdir(str_replace('//','/',$targetPath), 0777, true);
            $targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
            move_uploaded_file($tempFile,$targetFile);
            echo 'OK';
*/
            if($model->save())
                $this->redirect(Yii::app()->createUrl('experiments/view',array('id'=>$model->experiment__id)));

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
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);
            if(isset($_POST['Documents']))
            {
                $model->attributes=$_POST['Documents'];

                // If we have text content, update the filesystem.
                if (isset($model->document_id)) {
                    //error_log("Updating document {$model->document_id}: $model->body");

                    if ($model->experiment__id == null) {
                        $attached_to = "trials";
                        $target_id = $model->trial__id;
                    } else {
                        $attached_to = "experiments";
                        $target_id = $model->experiment__id;
                    }

                    $targetPath = Yii::getPathOfAlias('uploads').'/' . $attached_to.'/'. $target_id .'/' . $model->document_id . '/';

                    $targetFile =  str_replace('//','/',$targetPath) . $model->file_name;

                    $filesize = file_put_contents($targetFile, $model->body);
                    $model->filesize = $filesize;

                    $t = microtime(true);
                    $micro = sprintf("%06d",($t - floor($t)) * 1000000);
                    $d = new DateTime( date('Y-m-d H:i:s.'.$micro,$t) );
                    $model->last_updated = $d->format("Y-m-d H:i:s.u");

                }

                // If the name was changed, be sure to update the filesystem.

                if($model->save())
                    $this->redirect(array('view','id'=>$model->document_id));
            }


            $this->render('update',array(
                'model'=>$model,
            ));
    }

    public function actionDelete($id)
    {

        $model = $this->loadModel($id);
            if(Yii::app()->request->isPostRequest and $_POST["confirmation"] == "DELETE") {

                if ($model->experiment__id == null) {
                    $attached_to = "trials";
                    $target_id = $model->trial__id;
                    $redirectAry = array('trials/'.$model->trial__id);
                } else {
                    $attached_to = "experiments";
                    $target_id = $model->experiment__id;
                    $redirectAry = array('experiments/'.$model->experiment__id);
                }

                //$attached_to = $model->experiment__id == null ? "trials" : "experiments";
                $targetPath = Yii::getPathOfAlias('uploads').'/' . $attached_to.'/'. $target_id .'/' . $model->document_id . '/';
                unlink($targetPath . $model->file_name);
                $model->delete();
                $this->redirect($redirectAry);
                // Delete the row from the table.
            } else {
                if($model->experiment__id != null) {
                    $this->experiment = $model->experiment;
                } else {
                    $this->experiment = $model->trial->experiment;
                }
                $this->render('delete', array("model" => $model));
            }
    }

    public function loadModel($id) {
            $model = Documents::model()->findByPk($id);
            if($model===null)
                    throw new CHttpException(404, 'The requested file does not exist.');
            return $model;
    }
}
