<?php

class Invitations extends CActiveRecord {

        public function getDbConnection() {
                return Yii::app()->db2;
        }

        public function primaryKey() {
                return 'invitation_id';
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
		return 'invitations';
	}

        public function rules() {
                return array(
                       array('user__id, experiment__id, level, email_address, token', 'required'),
                       array('email_address+experiment__id', 'application.extensions.uniqueMultiColumnValidator', 'caseSensitive'=>true, 'message' => 'A user with that email address has already been invited to that experiment.'
                       ),
                );
        }

        public function relations() {
               return array(
                   'experiment' => array(self::BELONGS_TO, 'Experiments', 'experiment__id'),
                   'user' => array(self::BELONGS_TO, 'User', 'user__id'),
               );
        }

        public function attributeLabels() {
                return array(
                        'user__id' => 'Creator',
                        'invited__id' => 'Invited',
                        'email_address' => 'Email Address',
                        'level' => 'Level',
                        'experiment__id' => 'Experiment',
                        'token' => 'Token'
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
