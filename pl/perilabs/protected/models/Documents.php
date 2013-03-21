<?php

/**
 * This is the model class for table "documents".
 *
 * The followings are the available columns in table 'documents':
 * @property integer $document_id
 * @property string $file_name
 * @property integer $experiment__id
 * @property integer $trial__id
 * @property integer $user__id
 * @property string $date_created
 * @property string $last_updated
 * @property string $mime
 * @property integer $filesize
 *
 * The followings are the available model relations:
 * @property Experiments $experiment
 * @property Trials $trial
 */
class Documents extends CActiveRecord
{
    /**
     * @return string the body contents of a text-based document.
     */
    public function getBody() {
        // Received new/updated document content via POST data.
        if (isset($_POST['Documents']['body'])) {
            $value = $_POST['Documents']['body'];
        // Updating an existing document, so load it from disk.
        } elseif ($this->document_id) {
            //$value = Yii::app()->controller->id."/".Yii::app()->controller->action->id;
            if ($this->experiment__id == null) {
                $attached_to = "trials";
                $experiment_obj = $this->trial->experiment;
                $trial_obj = $this->trial;
            } else {
                $attached_to = "experiments";
                $experiment_obj = $this->experiment;
                $trial_obj = false;
            }
            $targetPath = Yii::getPathOfAlias('webroot') . '/uploads/'.$attached_to.'/'. $this->experiment__id .'/' . $this->document_id . '/';
            $value = file_get_contents($targetPath . $this->file_name);//print_r($this, true);

        } else {
            $value = '';
        }
        
        return $value;
        
    }

    //Parse an uploaded document for results
    public function parse() {
        error_log('parse function called');
        $targetPath = Yii::getPathOfAlias('uploads') . '/trials/'. $this->trial__id .'/' . $this->document_id . '/';
        $targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];

        // Variables used for both CSV and XLS
            $file_handle = fopen($targetFile, 'r');
            $parseable_content = false;
            $metricPositions = array();
            $metricsFound = true;
            $metricsAry = array();

            if(strpos($this->mime, 'text') !== false) {
                    //parse csv file
                    error_log('parsing csv');
                    while(!feof($file_handle)) {
                            $line = fgetcsv($file_handle);
                            if($parseable_content) {
                                    if($line[0] != '') {
                                            //new result
                                            $result = new Results();
                                            $result->trial__id = $this->trial__id;
                                            $result->title = $line[0];
                                            $result->document__id = $this->document_id;
                                            $result->save();
                                            foreach($metricPositions as $key => $metric):
                                                    $metricsAry[$metric->metric_id] = $line[$key];
                                            endforeach;
                                            $result->buildMetrics($metricsAry);
                                    }
                            } else {
                                    if($line[0] == "Name, Title, or ID#") {
                                            // Verify the position of the metrics
                                            foreach($line as $key => $title):
                                                    if($title != '' and $title != "Name, Title, or ID#") {
                                                            $metric = Metrics::model()->findByAttributes(
                                                                    array(
                                                                            'experiment__id' => $this->trial->experiment__id, 
                                                                            'title' => $title
                                                                    )
                                                            );
                                                            if($metric == NULL) { 
                                                                    $metricsFound = false;
                                                            }
                                                            $metricPositions[$key] = $metric;
                                                            /* error_log($key.': '.$title.'-'.$metric->metric_id); */
                                                    }
                                            endforeach;

                                            $correctMetricCount = sizeof($metricPositions) == $this->trial->experiment->metricCount;

                                                // Start parsing content in the next pass
                                                if($metricsFound and $correctMetricCount) {
                                                        $parseable_content = true;
                                                } else {
                                                        $this->parseable = false;
                                                        if(!$metricsFound) {
                                                                $this->parse_error_reason = "One or more of the metrics in this file is misnamed or is no longer part of the experiment. Please check the field names and re-upload.";
                                                        }
                                                        if(!$correctMetricCount) {
                                                                $this->parse_error_reason = "This document has a different number of metrics defined than are present in the experiment. Please check the template for errors and re-upload";
                                                        }
                                                        $this->save();
                                                }
                                    }
                            }
                    }
            } elseif (strpos($this->mime, 'vnd') !== false) {
                    //parse excel file
                    error_log('parsing excel');
                    $phpexcel = new PHPExcel();
                    $reader = PHPExcel_IOFactory::createReader('Excel5');
                    $reader->setReadDataOnly(true);
                    $excel = $reader->load($targetFile);
                    $excelWorksheet = $excel->getActiveSheet();
                    $highestRow = $excelWorksheet->getHighestRow();
                    $highestColumn = PHPExcel_Cell::columnIndexFromString($excelWorksheet->getHighestColumn());
                    for($row = 1; $row <= $highestRow; ++$row) {
                            if($parseable_content) {
                                    $title = $excelWorksheet->getCellByColumnAndRow(0, $row)->getCalculatedValue();
                                    if($title != '') {
                                            $result = new Results();
                                            $result->trial__id = $this->trial__id;
                                            $result->document__id = $this->document_id;
                                            $result->title = $title;
                                            $result->save();
                                            $metricsAry = array();
                                            foreach($metricPositions as $key => $metric):
                                                    $metricsAry[$metric->metric_id] = $excelWorksheet->getCellByColumnAndRow($key, $row)->getCalculatedValue();
                                            endforeach;
                                            $result->buildMetrics($metricsAry);
                                    }
                            } else {
                                    $title = $excelWorksheet->getCellByColumnAndRow(0, $row)->getCalculatedValue();
                                    if($title == "Name, Title, or ID#") {
                                            for($column = 0; $column <= $highestColumn; ++$column) {
                                                    $title = $excelWorksheet->getCellByColumnAndRow($column, $row)->getCalculatedValue();
                                                    if($title != '' and $title != "Name, Title, or ID#") {
                                                            $metric = Metrics::model()->findByAttributes(
                                                                    array(
                                                                            'experiment__id' => $this->trial->experiment__id,
                                                                            'title' => $title
                                                                    )
                                                            );
                                                            if($metric == NULL) {
                                                                    $metricsFound = false;
                                                            }
                                                            $metricPositions[$column] = $metric;
                                                    }
                                            }

                                            $correctMetricCount = sizeof($metricPositions) == $this->trial->experiment->metricCount;

                                            if($metricsFound and $correctMetricCount) {
                                                    $parseable_content = true;
                                            } else {
                                                    $this->parseable = false;
                                                    if(!$metricsFound) {
                                                            $this->parse_error_reason = "One or more of the metrics in this file is misnamed or is no longer part of the experiment. Please check the field names and re-upload.";
                                                    }
                                                    if(!$correctMetricCount) {
                                                            $this->parse_error_reason = "This document has a different number of metrics defined than are present in the experiment. Please check the template for errors and re-upload";
                                                    }
                                                    $this->save();
                                            }
                                    }
                            }
                    }
            } else {
                    $this->parse_error_reason = "This document type is not supported by the application.";
                    $this->save();
            }
    }

    /**
     * @return object the associated database's CDbConnection object
     */
    public function getDbConnection() {
        return Yii::app()->db2;
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Documents the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'documents';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('file_name', 'required'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'experiment' => array(self::BELONGS_TO, 'Experiments', 'experiment__id'),
            'trial' => array(self::BELONGS_TO, 'Trials', 'trial__id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'document_id' => 'Document',
            'file_name' => 'File Name',
            'experiment__id' => 'Experiment',
            'trial__id' => 'Trial',
            'user__id' => 'User',
            'date_created' => 'Date Created',
            'last_updated' => 'Last Updated',
            'mime' => 'Mime Type',
            'filesize' => 'File Size',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('document_id',$this->document_id);
        $criteria->compare('file_name',$this->file_name,true);
        $criteria->compare('experiment__id',$this->experiment__id);
        $criteria->compare('trial__id',$this->trial__id);
        $criteria->compare('user__id',$this->user__id);
        $criteria->compare('date_created',$this->date_created,true);
        $criteria->compare('last_updated',$this->last_updated,true);
        $criteria->compare('mime',$this->mime,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
