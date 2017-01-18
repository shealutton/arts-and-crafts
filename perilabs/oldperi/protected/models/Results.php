<?php

/**
 * This is the model class for table "results".
 *
 * The followings are the available columns in table 'results':
 * @property integer $result_id
 * @property integer $trial__id
 * @property string $title
 *
 * The followings are the available model relations:
 * @property Trials $trial
 * @property MInt[] $mInts
 * @property MReal[] $mReals
 * @property MText[] $mTexts
 * @property MTime[] $mTimes
 * @property MBin[] $mBins
 * @property MBool[] $mBools
 */
class Results extends CActiveRecord
{
	public function getDbConnection()
	{
		return Yii::app()->db2;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Results the static model class
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
		return 'results';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('result_id, trial__id', 'required'), //Commented after we added the result_id_seq to the DB
			array('trial__id', 'required'),
			//array('result_id, trial__id', 'numerical', 'integerOnly'=>true), //Commented after we added the result_id_seq to the DB
			array('trial__id', 'numerical', 'integerOnly'=>true),
			array('title', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('result_id, trial__id, title', 'safe', 'on'=>'search'),
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
			'trial' => array(self::BELONGS_TO, 'Trials', 'trial__id'),
			'mInts' => array(self::HAS_MANY, 'MInt', 'result__id'),
			'mReals' => array(self::HAS_MANY, 'MReal', 'result__id'),
			'mTexts' => array(self::HAS_MANY, 'MText', 'result__id'),
			'mTimes' => array(self::HAS_MANY, 'MTime', 'result__id'),
			'mBins' => array(self::HAS_MANY, 'MBin', 'result__id'),
			'mBools' => array(self::HAS_MANY, 'MBool', 'result__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'result_id' => 'Result',
			'trial__id' => 'Trial',
			'title' => 'Title',
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

		$criteria->compare('result_id',$this->result_id);
		$criteria->compare('trial__id',$this->trial__id);
		$criteria->compare('title',$this->title,true);	

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function value_for_metric($metric)
        {
                switch ($metric->data_type__id) {
                case 1:
                        //boolean
                        $model = MBool::model();
                        break;
                case 2:
                        //integer
                        $model = MInt::model();
                        break;
                case 3:
                        //real number (3)
                        $model = MReal::model();
                        break;
                case 4:
                        //text
                        $model = MText::model();
                        break;
                case 6:
                        $model = MTime::model();
                        break;
                }
                $datum = $model->find('"metric__id"=:metric_id AND "result__id"=:result_id', 
                        array(":metric_id" => $metric->metric_id, ":result_id" => $this->result_id));
                if ($datum != null) {
                        if($metric->data_type__id == 1) {
                                return ($datum->value == NULL) ? 0 : 1;
                        } else {
                                return $datum->value;
                        }
                } else {
                        return NULL;
                }

        }

        public function buildMetrics($metrics_array)
        {
                foreach($metrics_array as $metric_id => $value):
                        $metric = Metrics::model()->findByPK($metric_id);
                        if($metric != NULL) {
                                switch($metric->data_type__id) {
                                case 1:
                                        //boolean
                                        $model = MBool::model();
                                        break;
                                case 2:
                                        //integer
                                        $model = MInt::model();
                                        break;
                                case 3:
                                        //real
                                        $model = MReal::model();
                                        break;
                                case 4:
                                        //text
                                        $model = MText::model();
                                        break;
                                case 6:
                                        //time
                                        $model = MTime::model();
                                        break;
                                }

                                $datum = $model->find('"result__id"=:result_id AND "metric__id"=:metric_id', 
                                        array(":result_id"=>$this->result_id, ":metric_id"=>$metric_id));
                                if($datum == NULL) {
                                        $datum = new $model();
                                }
                                $datum->result__id = $this->result_id;
                                $datum->metric__id = $metric_id;
                                $datum->value = $value;
                                $datum->save(); 
                        }
                endforeach;
        }
}
