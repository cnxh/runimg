<?php
class RegisterForm extends CFormModel
{
	public $nickName;
	public $email;
	public $password;
	public $rePassword;
	public $applyTermsService = 1;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('nickName, email, password, rePassword, applyTermsService', 'required', 'message' => "{attribute}不能为空"),
			array('nickName', 'checkNickName'),
			array('email', 'email', 'message' => '邮箱格式错误'),
			array('email', 'checkEmail'),
			array('password', 'checkPassword'),
			array('rePassword', 'compare', 'compareAttribute'=>'password', 'message'=>'两次密码输入不一致'),
			array('applyTermsService', 'checkApplyTermsService'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'nickName' => '昵称',
			'email' => '邮箱',
			'password' => '密码',
			'rePassword' => '重复密码',
			'applyTermsService' => '服务协议',
		);
	}

	public function checkEmail(){
		if(!$this->hasErrors()){
			$user = User::model()->getUserInfoCache($this->email, 'email');
			if(!empty($user)){
				$this->addError('email', '该Email已注册');
			}
		}
	}

	public function checkNickName(){
		if(mb_strlen($this->nickName, 'UTF-8')< 3){
			$this->addError('nickName', '昵称不能少于3个字符');
		}
		if(!$this->hasErrors()){
			$user = User::model()->getUserInfoCache($this->nickName, 'nick_name');
			if(!empty($user)){
				$this->addError('nickName', '该昵称已被占用');
			}
		}
	}

	public function checkPassword(){
		if(strlen($this->password)< 6){
			$this->addError('password', '密码不能少于6个字符');
		}
	}

	public function checkApplyTermsService(){
		if(!$this->applyTermsService){
			$this->addError('applyTermsService', '必须同意服务协议才能继续');
		}
	}


}
