<?php

/**
 * This is the model class for table "constants".
 *
 * The followings are the available columns in table 'constants':
 * @property integer $constant_id
 * @property string $experiment__id
 * @property string $title
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Experiments $experiment
 */
class Constants extends CActiveRecord
{
	public function getDbConnection()
	{
		return Yii::app()->db2;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Constants the static model class
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
		return 'constants';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, description, experiment__id', 'required'),
			array('title', 'length', 'max'=>100),
			// Commented now that description is text and not varchar(300)
			//array('description', 'length', 'max'=>300),
                        array('experiment__id, title, description, ts_en', 'safe', 'on'=>'copy'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('constant_id, experiment__id, title, description', 'safe', 'on'=>'search'),
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
			'experiment' => array(self::BELONGS_TO, 'Experiments', 'experiment__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'constant_id' => 'Constant',
			'experiment__id' => 'Experiment',
			'title' => 'Title',
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

		$criteria->compare('constant_id',$this->constant_id);
		$criteria->compare('experiment__id',$this->experiment__id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
