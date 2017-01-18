<?php

/**
 * RecoveryForm class.
 * User recovery password.
 * It is used by the 'recovery' action of 'UserController'.
 */
class RecoveryForm extends CFormModel
{

    public $password;
    public $status;
    public $activationKey;
    public $lastpasswordchange;
    public $login_or_email;
    public $verifyPassword;
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            array('login_or_email', 'required', 'on'=>'recovery'),
            array('verifyPassword', 'compare', 'compareAttribute' => 'password', 'on'=>'change'),
            array('password, verifyPassword', 'required', 'on'=>'change'),
            array('login_or_email', 'match', 'pattern' => '/^[0-9a-zA-Z_!#.,-@$%*\(\)\+=\&]+$/'),
        );
    }

    /**
     * Declares attribute labels.
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
            'status' => 'Status',
            'organization' => 'Organization name',
            'plan' => 'Plan',
            'newPassword' => 'New password',
            'organization__id' => 'Organization',
        );
    }

    protected function beforeValidate()
    {
        if($this->getScenario() == 'recovery') {
            $this->activationKey = RandomGenerator::generateRandomHash();
            $this->status = 0;
        }
        if($this->getScenario() == 'change') {
            $this->activationKey = NULL;
            $this->status = 1;
            $this->lastpasswordchange = time();
        }


        return parent::beforeValidate();
    }



}
