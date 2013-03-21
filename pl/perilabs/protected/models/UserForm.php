<?php

/**
 * UserForm class.
 * Create/Update user.
 * It is used by the 'create/update' action of 'UserController'.
 */
class UserForm extends CFormModel
{

    public $id;
    public $username;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $newPassword = NULL;
    public $verifyPassword;
    public $verifyCode;
    public $status;
    public $activationKey;
    public $createtime;
    public $role;
    public $organization;
    public $plan;
    public $lastpasswordchange;

    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            array('password, verifyPassword', 'required', 'on'=>'create'),
            array('verifyPassword', 'compare', 'compareAttribute' => 'password', 'on'=>'create'),
            array('verifyPassword', 'compare', 'compareAttribute' => 'newPassword', 'on'=>'update'),
            array('username, email, firstname, lastname, role, status', 'required'),
            array('role', 'in', 'range'=>array(User::USER_ROLE, User::MANAGER_ROLE, User::ADMIN_ROLE)),
            array('status', 'in', 'range'=>array(User::STATUS_INACTIVE, User::STATUS_BANNED, User::STATUS_ACTIVE)),
            array('verifyPassword, newPassword', 'match', 'pattern' => '/^[0-9a-zA-Z_!#.,-@$%*\(\)\+=\&]+$/'),
            array('id, username, email, password, activationKey, createtime, firstname, lastname, plan, organization__id, lastpasswordchange', 'safe'),
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
            'organization__ids' => 'Organizations',
            'plan' => 'Plan',
            'newPassword' => 'New password',
        );
    }
    
    protected function beforeValidate()
    {
        if($this->getScenario() == 'create') {
            $this->createtime = time();
            $this->status = User::STATUS_INACTIVE;
            $this->activationKey = RandomGenerator::generateRandomHash();
        }
        if($this->getScenario() == 'update' && $this->newPassword != NULL) {
            $this->lastpasswordchange = time();
        }

        return parent::beforeValidate();
    }


}
