<?php

/**
 * This is the model class for table "variables_time".
 *
 * The followings are the available columns in table 'variables_time':
 * @property string $var_time_id
 * @property integer $variable__id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property Variables $variable
 */
class VariablesTime extends CActiveRecord
{
	public function getDbConnection()
        {
                return Yii::app()->db2;
        }

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VariablesTime the static model class
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
		return 'variables_time';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('variable__id, value', 'required'),
			array('variable__id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('var_time_id, variable__id, value', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'var_time_id' => 'Var Time',
			'variable__id' => 'Variable',
			'value' => 'Value',
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

		$criteria->compare('var_time_id',$this->var_time_id,true);
		$criteria->compare('variable__id',$this->variable__id);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
