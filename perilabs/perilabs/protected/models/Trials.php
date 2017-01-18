<?php

/**
 * This is the model class for table "trials".
 *
 * The followings are the available columns in table 'trials':
 * @property integer $trial_id
 * @property integer $experiment__id
 * @property string $title
 * @property boolean $skip_f
 * @property string $last_updated
 * @property integer $sequence_num
 * @property string $locked_f
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property VInt[] $vInts
 * @property VReal[] $vReals
 * @property VText[] $vTexts
 * @property VTime[] $vTimes
 * @property Results[] $results
 * @property VBin[] $vBins
 * @property VBool[] $vBools
 * @property Experiments $experiment
 */
class Trials extends CActiveRecord
{
	public function getDbConnection()
	{
		return Yii::app()->db2;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Trials the static model class
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
		return 'trials';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('experiment__id, title', 'required'), //Added 20120209 
			array('experiment__id, sequence_num', 'numerical', 'integerOnly'=>true), //Added 20120209
			array('title', 'length', 'max'=>100),
                        array('experiment__id, title, last_updated, sequence_num, ts_en', 'safe', 'on'=>'copy'),
			array('skip_f, update_time, locked_f', 'safe'),
			array('trial_id, experiment__id, title, skip_f, last_updated, sequence_num, locked_f', 'safe', 'on'=>'search'),
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
			'vInts' => array(self::HAS_MANY, 'VInt', 'trial__id'),
			'vReals' => array(self::HAS_MANY, 'VReal', 'trial__id'),
			'vTexts' => array(self::HAS_MANY, 'VText', 'trial__id'),
			'vTimes' => array(self::HAS_MANY, 'VTime', 'trial__id'),
			'results' => array(self::HAS_MANY, 'Results', 'trial__id'),
			'vBins' => array(self::HAS_MANY, 'VBin', 'trial__id'),
			'vBools' => array(self::HAS_MANY, 'VBool', 'trial__id'),
			'experiment' => array(self::BELONGS_TO, 'Experiments', 'experiment__id'),
			'results' => array(self::HAS_MANY, 'Results', 'trial__id', 'order'=>'result_id ASC'),
			'resultCount' => array(self::STAT, 'Results', 'trial__id'),
			'documents' => array(self::HAS_MANY, 'Documents', 'trial__id'),
			'documentsCount' => array(self::STAT, 'Documents', 'trial__id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'trial_id' => 'Trial',
			'experiment__id' => 'Experiment',
			'title' => 'Title',
			'skip_f' => 'Skip F',
			'last_updated' => 'Last Updated',
			'sequence_num' => 'Sequence Num',
			'locked_f' => 'Locked F',
			'date_created' => 'Date Created',
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

		$criteria->compare('trial_id',$this->trial_id);
		$criteria->compare('experiment__id',$this->experiment__id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('skip_f',$this->skip_f);
		$criteria->compare('last_updated',$this->last_updated,true);
		$criteria->compare('sequence_num',$this->sequence_num);
		$criteria->compare('locked_f',$this->locked_f,true);
		$criteria->compare('date_created',$this->date_created,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function value_for_variable($var)
        {
                switch ($var->data_type__id) {
                case 1:
                        //boolean
                        $model = VBool::model();
                        break;
                case 2:
                        //integer
                        $model = VInt::model();
                        break;
                case 3:
                        //real number (3)
                        $model = VReal::model();
                        break;
                case 4:
                        //text
                        $model = VText::model();
                        break;
                case 6:
                        $model = VTime::model();
                        break;
                }
                $datum = $model->find('"variable__id"=:varid AND "trial__id"=:trialid', array(":trialid" => $this->trial_id, ":varid" => $var->variable_id));
                if ($datum != null) {
                        return $datum->value;
                } else {
                        return NULL;
                }

        }
        public function average_for_metric($metric) {
                switch($metric->data_type__id) {
                case 1:
                        //boolean
                        $sql = 'SELECT COUNT(*) as yeses from "results" "t" INNER JOIN "m_bool" "b" ON "t"."result_id" = "b"."result__id" WHERE "t"."trial__id"='.$this->trial_id.' AND "b"."metric__id"='.$metric->metric_id.' AND "b"."value"=TRUE';
                        $command = Yii::app()->db2->createCommand($sql);
                        $result = $command->queryAll();
                        $yeses = (int)$result[0]["yeses"];
                        $total = Results::model()->count('"t"."trial__id"=:trial_id', array(":trial_id" => $this->trial_id));
                        if($total > 0) {
                                return $yeses / $total;
                        } else {
                                return 'NaN';
                        }
                        break;
                case 2:
                        //integer
                        $sql = 'SELECT AVG("b"."value") as average from "results" "t" INNER JOIN "m_int" "b" on "t"."result_id" = "b"."result__id" WHERE "t"."trial__id"='.$this->trial_id.' AND "b"."metric__id"='.$metric->metric_id;
                        $command = Yii::app()->db2->createCommand($sql);
                        $result = $command->queryAll();
                        $avg = (float)$result[0]["average"];
                        return $avg;
                        break;
                case 3:
                        //real number
                        $sql = 'SELECT AVG("b"."value") as average from "results" "t" INNER JOIN "m_real" "b" on "t"."result_id" = "b"."result__id" WHERE "t"."trial__id"='.$this->trial_id.' AND "b"."metric__id"='.$metric->metric_id;
                        $command = Yii::app()->db2->createCommand($sql);
                        $result = $command->queryAll();
                        $avg = (float)$result[0]["average"];
                        return $avg;
                }
                return 'Coming Soon...';
        }
}
