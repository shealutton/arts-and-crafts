<?php

/**
 * This is the model class for table "groups".
 *
 * The followings are the available columns in table 'groups':
 * @property string $group_id
 * @property string $title
 * @property integer $user__id
 * @property string $date_created
 * @property boolean $status
 *
 * The followings are the available model relations:
 * @property Users[] $users
 * @property Users $user
 */
class Groups extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Groups the static model class
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
		return 'groups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user__id, date_created', 'required'),
			array('user__id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>80),
			array('status', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('group_id, title, user__id, date_created, status', 'safe', 'on'=>'search'),
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
			'users' => array(self::MANY_MANY, 'Users', 'group_memberships(group__id, user__id)'),
			'user' => array(self::BELONGS_TO, 'Users', 'user__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'group_id' => 'Group',
			'title' => 'Title',
			'user__id' => 'User',
			'date_created' => 'Date Created',
			'status' => 'Status',
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

		$criteria->compare('group_id',$this->group_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('user__id',$this->user__id);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}