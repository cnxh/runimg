<?php

/**
 * This is the model class for table "img".
 *
 * The followings are the available columns in table 'img':
 * @property integer $id
 * @property string $hash_code
 * @property string $file_path
 * @property integer $start_time
 * @property integer $expire_time
 * @property integer $width
 * @property integer $height
 * @property integer $size
 * @property string $mime
 * @property integer $create_time
 * @property string $ip
 * @property integer $status
 */
class BaseImg extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseImg the static model class
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
		return 'img';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hash_code, file_path, expire_time', 'required'),
			array('start_time, expire_time, width, height, size, create_time, status', 'numerical', 'integerOnly'=>true),
			array('hash_code, mime', 'length', 'max'=>32),
			array('file_path', 'length', 'max'=>64),
			array('ip', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, hash_code, file_path, start_time, expire_time, width, height, size, mime, create_time, ip, status', 'safe', 'on'=>'search'),
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
			'hash_code' => 'Hash Code',
			'file_path' => 'File Path',
			'start_time' => 'Start Time',
			'expire_time' => 'Expire Time',
			'width' => 'Width',
			'height' => 'Height',
			'size' => 'Size',
			'mime' => 'Mime',
			'create_time' => 'Create Time',
			'ip' => 'Ip',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('hash_code',$this->hash_code,true);
		$criteria->compare('file_path',$this->file_path,true);
		$criteria->compare('start_time',$this->start_time);
		$criteria->compare('expire_time',$this->expire_time);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('size',$this->size);
		$criteria->compare('mime',$this->mime,true);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}