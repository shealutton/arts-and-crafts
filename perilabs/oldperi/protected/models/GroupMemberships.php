<?php

/**
 * This is the model class for table "group_memberships".
 *
 * The followings are the available columns in table 'group_memberships':
 * @property string $membership_id
 * @property integer $group__id
 * @property integer $user__id
 */
class GroupMemberships extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GroupMemberships the static model class
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
		return 'group_memberships';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group__id, user__id', 'required'),
			array('group__id, user__id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('membership_id, group__id, user__id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'membership_id' => 'Membership',
			'group__id' => 'Group',
			'user__id' => 'User',
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

		$criteria->compare('membership_id',$this->membership_id,true);
		$criteria->compare('group__id',$this->group__id);
		$criteria->compare('user__id',$this->user__id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}