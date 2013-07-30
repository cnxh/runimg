<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $type = strpos($this->username, '@') === false ? 'nick_name' : 'email';
        $user = User::model()->getUserInfoCache($this->username,$type);
        if(empty($user)){
			$this->errorCode=self::ERROR_USERNAME_INVALID;
        }else{
           if(User::hashPassword($this->password, $user['salt']) != $user['password']){
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }else{
                $this->errorCode=self::ERROR_NONE;
            }
        }
		return !$this->errorCode;
	}
}