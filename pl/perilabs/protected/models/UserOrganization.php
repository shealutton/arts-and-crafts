<?php

/**
 * This is the model class for table "user_organization".
 *
 * The followings are the available columns in table 'user_organization':
 * @property integer user__id
 * @property integer organization__id
 */
class UserOrganization extends CActiveRecord
{

    public function getDbConnection()
    {
        return Yii::app()->db2;
    }
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserOrganization the static model class
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
		return 'user_organization';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user__id, organization__id', 'required'),
			array('user__id, organization__id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user__id, organization__id', 'safe', 'on'=>'search'),
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
            'organization' => array(self::BELONGS_TO, 'Organizations', 'organization__id'),
            'user' => array(self::BELONGS_TO, 'User', 'user__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'user__id' => 'User',
			'organization__id' => 'Organization',
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

		$criteria->compare('user__id',$this->user__id,true);
		$criteria->compare('organization__id',$this->organization__id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}