<?php

/**
 * RegistrationForm class.
 * Registration new users.
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends CFormModel
{
    
    public $username;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $verifyPassword;
    public $verifyCode;
    public $status;
    public $activationKey;
    public $createtime;
    public $role;
    public $organization;
    public $plan;
    public $organization__id;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            array('verifyCode', 'captcha', 'allowEmpty' => !extension_loaded('gd'), 'captchaAction' => 'user/captcha'),
            array('username, email, password, firstname, lastname, verifyPassword, plan, organization', 'required'),
            array('verifyPassword', 'compare', 'compareAttribute' => 'password'),
            array('verifyPassword', 'match', 'pattern' => '/^[0-9a-zA-Z_!#.,-@$%*\(\)\+=\&]+$/'),
            array('username, email, password, activationKey, createtime, firstname, lastname, status, plan, organization__id, verifyCode, verifyPassword, organization', 'safe'),
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
        );
    }
    
    protected function beforeValidate()
    {
        $this->createtime = time();
        $this->status = User::STATUS_INACTIVE;
        $this->activationKey = RandomGenerator::generateRandomHash();

        return parent::beforeValidate();
    }

}
