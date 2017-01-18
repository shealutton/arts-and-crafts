<?php

/**
 * This is the model class for table "v_int".
 *
 * The followings are the available columns in table 'v_int':
 * @property integer $variable__id
 * @property integer $value
 * @property string $v_value_id
 * @property integer $trial__id
 *
 * The followings are the available model relations:
 * @property Variables $variable
 * @property Trials $trial
 */
class VInt extends CActiveRecord
{

	public function getDbConnection()
	{
		return Yii::app()->db2;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VInt the static model class
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
		return 'v_int';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('variable__id, value, trial__id', 'required'),
			array('variable__id, value, trial__id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('variable__id, value, v_value_id, trial__id', 'safe', 'on'=>'search'),
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
			'variable' => array(self::BELONGS_TO, 'Variables', 'variable__id'),
			'trial' => array(self::BELONGS_TO, 'Trials', 'trial__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'variable__id' => 'Variable',
			'value' => 'Value',
			'v_value_id' => 'V Value',
			'trial__id' => 'Trial',
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

		$criteria->compare('variable__id',$this->variable__id);
		$criteria->compare('value',$this->value);
		$criteria->compare('v_value_id',$this->v_value_id,true);
		$criteria->compare('trial__id',$this->trial__id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}