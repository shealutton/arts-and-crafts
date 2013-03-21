<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $user_id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property string $activationKey
 * @property integer $createtime
 * @property integer $lastvisit
 * @property integer $lastaction
 * @property integer $lastpasswordchange
 * @property integer $status
 * @property string $plan
 *
 */
class User extends CActiveRecord
{
    // USER STATUS
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = 2;

    //USER ROLE
    const USER_ROLE = 'user';
    const ADMIN_ROLE = 'admin';
    const MANAGER_ROLE = 'manager';
    const ROOT_ROLE = 'root';

    //USER PLAN
    const FREE_PLAN = 'free';
    const SMALL_PLAN = 'small';
    const MEDIUM_PLAN = 'medium';
    const LARGE_PLAN = 'large';
    const HUGE_PLAN = 'huge';

    public $userPassword = NULL;

    public function getDbConnection()
    {
        return Yii::app()->db2;
    }
    /**
    * Returns the static model of the specified AR class.
    * @param string $className active record class name.
    * @return User the static model class
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
        return 'users';
    }

    /**
        * @return array validation rules for model attributes.
        */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, email', 'unique'),
            array('id, createtime, lastvisit, lastaction, lastpasswordchange, status', 'numerical', 'integerOnly'=>true),
            array('email', 'email'),
            array('password', 'length', 'min' =>8),
            array('username', 'length', 'max'=>20),
            array('lastname', 'length', 'max'=>32),
            array('firstname', 'length', 'max'=>32),
            array('email', 'length', 'max'=>100),
            array('salt', 'length', 'max' => 32),
            array('password, activationKey', 'length', 'max'=>128),
            array('username, password, firstname, lastname, role, salt', 'match', 'pattern' => '/^[0-9a-zA-Z_!#.,-@$%*\(\)\+=\&]+$/'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, email, password, activationKey, createtime, firstname, lastname, lastvisit, lastaction, lastpasswordchange, status', 'safe', 'on'=>'search'),
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
            'memberships' => array(self::HAS_MANY, 'Memberships', 'user__id'),
            'organizations' => array(self::HAS_MANY, 'Organizations', array('organization__id' => 'organization_id'), 'through'=>'memberships'),
            'access_grants' => array(self::HAS_MANY, 'AccessGrants', 'user__id'),
            'experiments' => array(self::HAS_MANY, 'Experiments', 'user__id'),
            'invitations' => array(self::HAS_MANY, 'Invitations', 'user__id'),
        );
    }

    /**
        * @return array customized attribute labels (name=>label)
        */
    public function attributeLabels()
    {
        return array(
            'id' => 'User',
            'username' => 'Username',
            'firstname' => 'First name',
            'lastname' => 'Last name',
            'email' => 'E-Mail',
            'password' => 'Password',
            'activationKey' => 'Activation Key',
            'verifyCode' => 'Verification code',
            'verifyPassword' => 'Retype password',
            'createtime' => 'Create time',
            'lastvisit' => 'Last visit',
            'lastaction' => 'Last action',
            'lastpasswordchange' => 'Last password change',
            'status' => 'Status',
        );
    }

    /**
     * Get user status by number
     * @param string $no number of status
     * @return string $str return current status name
     */
    public static function getStatus($no)
    {
        $str = null;
        switch($no) {
            case self::STATUS_ACTIVE:
                $str = 'active';
                break;
            case self::STATUS_INACTIVE:
                $str = 'inactive';
                break;
            case self::STATUS_BANNED:
                $str = 'banned';
                break;
        }

        return $str;
    }

    /**
     * Get
     * @return
     */
    public static function getStatuses()
    {
        $arr = array(
            self::STATUS_INACTIVE => 'inactive',
            self::STATUS_BANNED => 'banned',
            self::STATUS_ACTIVE => 'active',
        );

        return $arr;
    }

    protected function beforeSave()
    {
        if($this->isNewRecord || $this->userPassword != NULL) {
            $this->salt = $this->generateSalt();
            $this->password = $this->hashPassword($this->password, $this->salt);
        }

        return parent::beforeSave();
    }

    /**
     * Validate password
     * @param $password
     * @return boolean
     */
    public function validatePassword($password)
    {
        return $this->hashPassword($password, $this->salt) == $this->password;
    }

    /**
     * Hashing password by md5 (deprecated function)
     * @param varchar $password
     * @param varchar $salt
     * @return string hashed string
     */
    public function hashPassword($password, $salt)
    {
        return md5($salt . $password);
    }

    /**
     * Generate salt
     * @return string
     */
    public function generateSalt()
    {
        return uniqid('',true);
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

        $criteria->compare('id',$this->id,true);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('firstname',$this->firstname,true);
        $criteria->compare('lastname',$this->lastname,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('createtime',$this->createtime);
        $criteria->compare('lastvisit',$this->lastvisit);
        $criteria->compare('lastaction',$this->lastaction);
        $criteria->compare('lastpasswordchange',$this->lastpasswordchange);
        $criteria->compare('status',$this->status, true);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }


         
}
