<?php

/**
 * This is the model class for table "variables".
 *
 * The followings are the available columns in table 'variables':
 * @property integer $variable_id
 * @property string $experiment__id
 * @property string $title
 * @property integer $data_type__id
 * @property double $min
 * @property double $max
 * @property double $increment
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Experiments $experiment
 * @property DataTypes $dataType
 * @property VInt[] $vInts
 * @property VReal[] $vReals
 * @property VText[] $vTexts
 * @property VTime[] $vTimes
 * @property VBin[] $vBins
 * @property VBool[] $vBools
 * @property VariablesTime[] $variablesTimes
 * @property VariablesText[] $variablesTexts
 */
class Variables extends CActiveRecord
{
	public function getDbConnection()
	{
		return Yii::app()->db2;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Variables the static model class
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
		return 'variables';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('experiment__id, title', 'required'),
			array('data_type__id', 'numerical', 'integerOnly'=>true),
			array('min, max, increment', 'numerical'),
			array('title', 'length', 'max'=>100),
                        array('experiment__id, title, data_type__id, min, max, increment, ts_en', 'safe', 'on'=>'copy'),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('variable_id, experiment__id, title, data_type__id, min, max, increment, description', 'safe', 'on'=>'search'),
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
			'vBools' => array(self::HAS_MANY, 'VBool', 'variable__id'),
			'experiment' => array(self::BELONGS_TO, 'Experiments', 'experiment__id'),
			'dataType' => array(self::BELONGS_TO, 'DataTypes', 'data_type__id'),
			'vBins' => array(self::HAS_MANY, 'VBin', 'variable__id'),
			'vInts' => array(self::HAS_MANY, 'VInt', 'variable__id'),
			'vTexts' => array(self::HAS_MANY, 'VText', 'variable__id'),
			'vReals' => array(self::HAS_MANY, 'VReal', 'variable__id'),
			'vTimes' => array(self::HAS_MANY, 'VTime', 'variable__id'),
			'variablesTimes' => array(self::HAS_MANY, 'VariablesTime', 'variable__id'),
			'variablesTexts' => array(self::HAS_MANY, 'VariablesText', 'variable__id'),
			'variablesTextsCount' => array(self::STAT, 'VariablesText', 'variable__id'),
			'variablesTimesCount' => array(self::STAT, 'VariablesTime', 'variable__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'variable_id' => 'Variable',
			'experiment__id' => 'Experiment',
			'title' => 'Title',
			'data_type__id' => 'Data Type',
			'min' => 'Min',
			'max' => 'Max',
			'increment' => 'Increment',
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

		$criteria->compare('variable_id',$this->variable_id);
		$criteria->compare('experiment__id',$this->experiment__id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('data_type__id',$this->data_type__id);
		$criteria->compare('min',$this->min);
		$criteria->compare('max',$this->max);
		$criteria->compare('increment',$this->increment);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function value_for_variable($var)
        {
                switch ($var->data_type__id) {
                case 1:
                        //boolean
                        MBool::model()->find("'variable__id'=:variable_id, 'trial__id'=:trial_id", array(":trial_id" => $this->trial_id));
                        break;
                case 2 or 3:
                        //integer (2) or real number (3)
                        $vals = array();
                        for($i = $variable->min; $i <= $variable->max; $i += $variable->increment) {
                                $vals[] = $i;
                        }
                        break;
                case 4:
                        //text
                        break;
                case 5:
                        //timestamp
                        break;
                }

        }
}
