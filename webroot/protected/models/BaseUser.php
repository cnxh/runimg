<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property integer $user_type
 * @property string $email
 * @property string $nick_name
 * @property string $password
 * @property string $salt
 * @property integer $sex
 * @property string $photo
 * @property string $register_ip
 * @property string $register_time
 * @property integer $email_checked
 * @property string $score
 * @property string $signature
 * @property integer $status
 */
class BaseUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseUser the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, nick_name, password, salt, photo', 'required'),
			array('user_type, sex, email_checked, status', 'numerical', 'integerOnly'=>true),
			array('email, nick_name, register_ip', 'length', 'max'=>45),
			array('password', 'length', 'max'=>40),
			array('salt', 'length', 'max'=>8),
			array('photo, signature', 'length', 'max'=>200),
			array('register_time', 'length', 'max'=>10),
			array('score', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_type, email, nick_name, password, salt, sex, photo, register_ip, register_time, email_checked, score, signature, status', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_type' => 'User Type',
			'email' => 'Email',
			'nick_name' => 'Nick Name',
			'password' => 'Password',
			'salt' => 'Salt',
			'sex' => 'Sex',
			'photo' => 'Photo',
			'register_ip' => 'Register Ip',
			'register_time' => 'Register Time',
			'email_checked' => 'Email Checked',
			'score' => 'Score',
			'signature' => 'Signature',
			'status' => 'Status',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_type',$this->user_type);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('nick_name',$this->nick_name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('register_ip',$this->register_ip,true);
		$criteria->compare('register_time',$this->register_time,true);
		$criteria->compare('email_checked',$this->email_checked);
		$criteria->compare('score',$this->score,true);
		$criteria->compare('signature',$this->signature,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}