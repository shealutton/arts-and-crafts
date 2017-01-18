<?php

/**
 * This is the model class for table "organizations".
 *
 * The followings are the available columns in table 'organizations':
 * @property string $organization_id
 * @property integer $name
 */
class Organizations extends CActiveRecord
{

    public function getDbConnection()
    {
        return Yii::app()->db2;
    }
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Organizations the static model class
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
		return 'organizations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('name', 'unique'),
			array('name', 'required'),
			array('organization_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('organization_id, name', 'safe', 'on'=>'search'),
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
            'memberships' => array(self::HAS_MANY, 'Memberships', 'organization__id'),
            'users' => array(self::HAS_MANY, 'User', array('user__id', 'user__id'), 'through' => 'memberships'),
            'experiments' => array(self::HAS_MANY, 'Experiments', 'organization__id'),
            'experimentsCount' => array(self::STAT, 'Experiments', 'organization__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'organization_id' => 'Organization',
			'name' => 'Name',
      'plan' => 'Plan'
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

		$criteria->compare('organization_id',$this->organization_id,true);
		$criteria->compare('name',$this->name);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function availableExperiments()
    {
            switch($this->plan) {
                case 'free':
                        return 2;
                        break;
                case 'small':
                        return 50;
                        break;
                case 'medium':
                        return 150;
                        break;
                case 'large':
                        return 500;
                        break;
                case 'huge':
                        return 1000000000; // A billion is effectively infinite for this use case.
                        break;
                default:
                        return 2;
                        break;
            }
    }

}
