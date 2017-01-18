<?php

/**
 * This is the model class for table "m_text".
 *
 * The followings are the available columns in table 'm_text':
 * @property integer $metric__id
 * @property integer $result__id
 * @property string $value
 * @property string $m_value_id
 *
 * The followings are the available model relations:
 * @property Results $result
 * @property Metrics $metric
 */
class MText extends CActiveRecord
{

	public function getDbConnection()
	{
		return Yii::app()->db2;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MText the static model class
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
		return 'm_text';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('metric__id, result__id, value', 'required'),
			array('metric__id, result__id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('metric__id, result__id, value, m_value_id', 'safe', 'on'=>'search'),
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
			'result' => array(self::BELONGS_TO, 'Results', 'result__id'),
			'metric' => array(self::BELONGS_TO, 'Metrics', 'metric__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'metric__id' => 'Metric',
			'result__id' => 'Result',
			'value' => 'Value',
			'm_value_id' => 'M Value',
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

		$criteria->compare('metric__id',$this->metric__id);
		$criteria->compare('result__id',$this->result__id);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('m_value_id',$this->m_value_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
