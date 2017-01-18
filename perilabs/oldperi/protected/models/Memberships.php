<?php

/**
 * This is the model class for table "membership".
 *
 * The followings are the available columns in table 'membership':
 * @property integer $membership_id
 * @property string $user__id
 * @property string $organization__id
 * @property string $level
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Organizations $organization
 */
class Memberships extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Membership the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

public function getDbConnection()
{
return Yii::app()->db2;
}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'memberships';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('level', 'required'),
			array('level', 'length', 'max'=>32),
			array('user__id, organization__id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('membership_id, user__id, organization__id, level', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user__id'),
			'organization' => array(self::BELONGS_TO, 'Organizations', 'organization__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'membership_id' => 'Memberships',
			'user__id' => 'User',
			'organization__id' => 'Organization',
			'level' => 'Level',
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

		$criteria->compare('membership_id',$this->membership_id);
		$criteria->compare('user__id',$this->user__id,true);
		$criteria->compare('organization__id',$this->organization__id,true);
		$criteria->compare('level',$this->level,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
