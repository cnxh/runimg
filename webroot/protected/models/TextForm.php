<?php
/**
 * File: TextForm.php
 * User: xiahao
 * Date: 13-7-11
 * Time: 下午9:20
 * Email: do.not.reply@foxmail.com
  */

class TextForm extends CFormModel{
	public $content;
	public $applyTermsService = 1;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// rememberMe needs to be a boolean
			array('content', 'required'),
            array('applyTermsService', 'checkApplyTermsService'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'content'=>'内容',
			'applyTermsService'=>'服务协议',

		);
	}

    public function checkApplyTermsService(){

        if($this->applyTermsService != 1){
            $this->addError('applyTermsService', '您需要同意我们的服务协议才能继续');
        }
    }
}