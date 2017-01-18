<?php

/**
 * This is the model class for table "metrics".
 *
 * The followings are the available columns in table 'metrics':
 * @property integer $metric_id
 * @property string $title
 * @property string $experiment__id
 * @property integer $data_type__id
 * @property string $description
 *
 * The followings are the available model relations:
 * @property MInt[] $mInts
 * @property MReal[] $mReals
 * @property MText[] $mTexts
 * @property MTime[] $mTimes
 * @property Experiments $experiment
 * @property DataTypes $dataType
 * @property MBin[] $mBins
 * @property MBool[] $mBools
 */
class Metrics extends CActiveRecord
{

	public function getDbConnection()
	{
		return Yii::app()->db2;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Metrics the static model class
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
		return 'metrics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('title', 'required'), REMOVED THE SEQUENCE FROM PG. Shea
			array('title, experiment__id', 'required'),
			array('data_type__id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>100),
            array('title, experiment__id, data_type__id, ts_en', 'safe', 'on'=>'copy'),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('metric_id, title, experiment__id, data_type__id, description', 'safe', 'on'=>'search'),
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
			'mInts' => array(self::HAS_MANY, 'MInt', 'metric__id'),
			'mReals' => array(self::HAS_MANY, 'MReal', 'metric__id'),
			'mTexts' => array(self::HAS_MANY, 'MText', 'metric__id'),
			'mTimes' => array(self::HAS_MANY, 'MTime', 'metric__id'),
			'experiment' => array(self::BELONGS_TO, 'Experiments', 'experiment__id'),
			'dataType' => array(self::BELONGS_TO, 'DataTypes', 'data_type__id'),
			'mBins' => array(self::HAS_MANY, 'MBin', 'metric__id'),
			'mBools' => array(self::HAS_MANY, 'MBool', 'metric__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'metric_id' => 'Metric',
			'title' => 'Title',
			'experiment__id' => 'Experiment',
			'data_type__id' => 'Data Type',
			'description' => 'Description',
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

		$criteria->compare('metric_id',$this->metric_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('experiment__id',$this->experiment__id,true);
		$criteria->compare('data_type__id',$this->data_type__id);
		$criteria->compare('description',$this->description,true);
						
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
