<?php

/**
 * This is the model class for table "experiments".
 *
 * The followings are the available columns in table 'experiments':
 * @property string $experiment_id
 * @property string $title
 * @property string $goal
 * @property string $date_created
 * @property string $last_updated
 * @property double $validity_average
 * @property double $value_average
 * @property string $data_shard_hostname
 * @property string $data_shard_db
 * @property string $data_shard_schema
 * @property string $data_shard_table
 * @property boolean $locked
 * @property integer $parent_id
 *
 * The followings are the available model relations:
 * @property Trials[] $trials
 * @property Variables[] $variables
 * @property Metrics[] $metrics
 * @property Constants[] $constants
 */
class Experiments extends CActiveRecord
{
        static $childExp = array();
        
	public function getDbConnection()
	{
		return Yii::app()->db2;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Experiments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'experiments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, goal, organization__id', 'required'),
      array('organization__id', 'numerical', 'integerOnly'=>true),
			array('validity_average, value_average', 'numerical'),
			array('title, goal', 'length', 'max'=>300),
        array('goal, organization__id, last_updated, validity_average, value_average, ts_en, parent_id', 'safe', 'on'=>'copy'),
			array('data_shard_hostname, data_shard_db, data_shard_schema, data_shard_table, locked', 'safe'),
                        // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('experiment_id, title, goal, date_created, last_updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'trials' => array(self::HAS_MANY, 'Trials', 'experiment__id'),
                    'trialCount' => array(self::STAT, 'Trials', 'experiment__id'),
                    'variables' => array(self::HAS_MANY, 'Variables', 'experiment__id'),
                    'variableCount' => array(self::STAT, 'Variables', 'experiment__id'),
                    'constants' => array(self::HAS_MANY, 'Constants', 'experiment__id'),
                    'constantCount' => array(self::STAT, 'Constants', 'experiment__id'),
                    'metrics' => array(self::HAS_MANY, 'Metrics', 'experiment__id'),
                    'metricCount' => array(self::STAT, 'Metrics', 'experiment__id'),
                    'accessGrants' => array(self::HAS_MANY, 'AccessGrants', 'experiment__id'),
                    //'accessGrantsCount' => array(self::STAT, 'AccessGrants', 'experiment__id'),
                    'documents' => array(self::HAS_MANY, 'Documents', 'experiment__id'),
                    'documentsCount' => array(self::STAT, 'Documents', 'experiment__id'),
                    'invitations' => array(self::HAS_MANY, 'Invitations', 'experiment__id'),
                    'invitationsCount' => array(self::STAT, 'Invitations', 'experiment__id'),
                    'organization' => array(self::BELONGS_TO, 'Organizations', 'organization__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'experiment_id' => 'Experiment',
			'title' => 'Title',
			'goal' => 'Goal',
      'organization__id' => 'Organization',
			'date_created' => 'Date Created',
			'last_updated' => 'Last Updated',
			'validity_average' => 'Validity Average',
			'value_average' => 'Value Average',
			'data_shard_hostname' => 'Data Shard Hostname',
			'data_shard_db' => 'Data Shard Db',
			'data_shard_schema' => 'Data Shard Schema',
			'data_shard_table' => 'Data Shard Table',
			'locked' => 'Locked',
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

		$criteria->compare('experiment_id',$this->experiment_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('goal',$this->goal,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('last_updated',$this->last_updated,true);
		//$criteria->compare('validity_average',$this->validity_average);
		//$criteria->compare('value_average',$this->value_average);
		//$criteria->compare('data_shard_hostname',$this->data_shard_hostname,true);
		//$criteria->compare('data_shard_db',$this->data_shard_db,true);
		//$criteria->compare('data_shard_schema',$this->data_shard_schema,true);
		//$criteria->compare('data_shard_table',$this->data_shard_table,true);
		//$criteria->compare('locked',$this->locked);

		$criteria->with = array('variables', 'variableCount', 'constants', 'constantCount', 'metrics', 'metricCount');
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
        * Returns children items for copies of experiment.
        * @param object $arrModels all experiments by user.
        * @param integer $experiment_id.
        * @param integer $margin length of the left margin.
        * @return Experiments the static model class
        */
        public static function childrenExperiments($arrModels, $experiment_id, $margin, $no)
        { 
            $i = 1;
            foreach($arrModels as $data) {
                if($data->parent_id == $experiment_id && $data->parent_id != NULL) {
                    self::$childExp[] = array('data'=>$data, 'margin'=>$margin, 'no'=>$no.'.'.$i);
                    Experiments::childrenExperiments($arrModels, $data->experiment_id, $margin+50, $no.'.'.$i);
                    $i++;
                }
            }
            return self::$childExp;
        }

        /**
         * Save copy experiment.
         * @param object $relation model relation.
         * @param object $newModel instance of the class.
         * @param array $attributes all addition properties.
         * @return boolean if copy saved then TRUE else FALSE
         */
        public function copyExp($relation, $newModel, $attributes = array())
        {
            foreach($relation as $model) {
                $copy = $newModel;
                $copy->attributes = $model->getAttributes();
                foreach($attributes as $name=>$val) {
                    $copy->$name = $val;
                }
                if($copy->save()) {
                    return true;
                } else {
                    return false;
                }

            }
        }

}
