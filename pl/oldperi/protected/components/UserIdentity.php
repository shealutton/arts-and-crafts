<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    protected $_id;

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user=User::model()->find('LOWER(username)=?',array(strtolower($this->username)));
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif(!$user->validatePassword($this->password)) {
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
        }
		else {
			$this->_id=$user->id;
			$this->username=$user->username;
			$this->errorCode=self::ERROR_NONE;

           // $this->onAuthenticate(new CEvent($user));
		}
		return $this->errorCode==self::ERROR_NONE;
	}

    /**
     * Check user status.
     * @return string return errorCode.
     */
    public function checkStatus()
    {
        $user=User::model()->find('LOWER(username)=?',array(strtolower($this->username)));
        if($user===null)
            $this->errorCode = "Incorrect username or password.";
        elseif($user->status == User::STATUS_INACTIVE) {
            $this->errorCode = "You are deleted or not activated. Please check your email for detail information!";
        }
        elseif($user->status == User::STATUS_BANNED) {
            $this->errorCode = "You are banned. Please check your email for detail information!";
        }
        elseif($user->status == User::STATUS_ACTIVE) {
            $this->errorCode = self::ERROR_NONE;
        }

        return $this->errorCode;
    }

    /**
     * Authenticate event.
     */
   // public function onAuthenticate(CEvent $event) {
    //    $this->raiseEvent('onAuthenticate', $event);
   // }

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
}
