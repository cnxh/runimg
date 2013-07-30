<?php
/**
 * File: UploadForm.php
 * User: xiahao
 * Date: 13-7-10
 * Time: 下午1:13
 * Email: do.not.reply@foxmail.com
  */

class UploadForm extends CFormModel{
	public $startTime;
	public $expireTime;
	public $startTimeInput;
	public $expireTimeInput;
	public $file;
	public $applyTermsService = 1;

	private $_startTimestamp;
	private $_expireTimestamp;

	public static $startTimeSet = array(
		0 => '立即生效',
		1 => '1天后开始生效',
		2 => '7天后开始生效',
		99 => '手动输入生效时间'
	);

	public static $expireTimeSet = array(
		1 => '生效1天后过期',
		2 => '生效3天后过期',
		3 => '生效7天后过期',
		4 => '生效一个月后过期',
		5 => '生效三个月后过期',
		0 => '手动输入过期时间'
	);
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// rememberMe needs to be a boolean
			array('applyTermsService', 'boolean'),
			array('startTime', 'checkStartTime'),
			array('expireTime', 'checkExpireTime'),
			array('startTimeInput', 'checkStartTimeInput'),
			array('expireTimeInput', 'checkExpireTimeInput'),
            array('file', 'checkFile'),
            array('applyTermsService', 'checkApplyTermsService'),
		);
	}

	public function init(){
		$this->startTimeInput = date('Y-m-d H:i:s', time()+1*3600*24);
		$this->expireTimeInput = date('Y-m-d H:i:s', time()+3*3600*24);
		return parent::init();
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'startTime'=>'开始生效时间',
			'startTimeInput'=>'手动输入开始生效时间',
			'expireTime'=>'过期时间',
			'expireTimeInput'=>'手动输入过期时间',

		);
	}

	public function checkStartTime(){
		if(!in_array($this->startTime, array_keys(self::$startTimeSet))){
			$this->addError('startTime', '请正确输入开始生效时间');
		}
	}

	public function checkStartTimeInput(){
		$this->startTimeInput = trim($this->startTimeInput);
		if($this->startTime == 99){//手动输入
			if(date('Y-m-d H:i:s',strtotime($this->startTimeInput)) == trim($this->startTimeInput)){
				if(strtotime($this->startTimeInput) <= time()){
					$this->addError('startTimeInput', '输入的开始生效时间不能是过去的时间哦');
				}else if(strtotime($this->startTimeInput) > strtotime("+3 month")){
					$this->addError('startTimeInput', '输入的开始生效时间最大为'.date('Y-m-d H:i:s',strtotime("+3 month")).'（即3个月后）');
				}
			}else{
				$this->addError('startTimeInput', '输入的开始生效时间格式错误');
			}
		}
	}


	public function checkExpireTime(){
		if(!in_array($this->expireTime, array_keys(self::$expireTimeSet))){
			$this->addError('expireTime', '请正确输入过期时间');
		}
	}

	public function checkExpireTimeInput(){
		$this->expireTimeInput = trim($this->expireTimeInput);
		if($this->expireTime == 0){
			if(date('Y-m-d H:i:s',strtotime($this->expireTimeInput)) == trim($this->expireTimeInput)){
				if($this->startTime == 99 && strtotime($this->expireTimeInput) <= strtotime($this->startTimeInput)){
					$this->addError('expireTimeInput', '输入的过期时间不能小于开始生效时间');
				}else if(strtotime($this->expireTimeInput) > strtotime("+6 month")){
					$this->addError('expireTimeInput', '输入的过期时间最大为'.date('Y-m-d H:i:s',strtotime("+6 month")).'（即6个月后）');
				}
			}else{
				$this->addError('expireTimeInput', '输入的过期时间格式错误');
			}
		}
	}



    public function checkFile(){
        $images = Yii::app()->user->getState('images');
        if(empty($images)){
            $this->addError('file', '请上传一张图片');
        }
    }

    public function checkApplyTermsService(){

        if($this->applyTermsService != 1){
            $this->addError('applyTermsService', '您需要同意我们的服务协议才能继续');
        }
    }

	public function afterValidate(){
		if(!$this->hasErrors()){
			//处理 startTime
			switch($this->startTime){
				case 1://
					$this->_startTimestamp = strtotime("+1 day");
					break;
				case 2://
					$this->_startTimestamp = strtotime("+7 day");
					break;
				case 99://
					$this->_startTimestamp = strtotime($this->startTimeInput);
					break;
				default:
					$this->_startTimestamp = 0;
			}
			//处理 expireTime
			switch($this->expireTime){
				case 1://
					$this->_expireTimestamp = strtotime("+1 day", $this->_startTimestamp == 0 ? time() : $this->_startTimestamp);
					break;
				case 2://
					$this->_expireTimestamp = strtotime("+3 day", $this->_startTimestamp == 0 ? time() : $this->_startTimestamp);
					break;
				case 3://
					$this->_expireTimestamp = strtotime("+7 day", $this->_startTimestamp == 0 ? time() : $this->_startTimestamp);
					break;
				case 4://
					$this->_expireTimestamp = strtotime("+1 month", $this->_startTimestamp == 0 ? time() : $this->_startTimestamp);
					break;
				case 5://
					$this->_expireTimestamp = strtotime("+3 month", $this->_startTimestamp == 0 ? time() : $this->_startTimestamp);
					break;
				case 0://
					$this->_expireTimestamp = strtotime($this->expireTimeInput);
					break;
				default:
					$this->_expireTimestamp = 0;
			}
		}
	}

	/**
	 * @return int   返回插入的id
	 */
	public function saveImg(){
		$images = Yii::app()->user->getState('images');
		if(!empty($images) && is_array($images) && $this->_expireTimestamp > 0){
			if(!empty($images[0]['path']) && file_exists($images[0]['path'])){
				$filePath = $this->moveImageToUploadDir($images[0]);
				$img = new Img;
				$img->create_time = time();
				$img->hash_code = md5(microtime(true).$images[0]['filename']);
				$img->file_path = $filePath;
				$img->start_time = $this->_startTimestamp;
				$img->expire_time = $this->_expireTimestamp;
				$img->size = $images[0]['size'];
				$img->mime = $images[0]['mime'];
				$img->ip = Yii::app()->request->userHostAddress;
				$img->status = 1;
				$result = $img->save();

				if($result){
					Yii::app()->user->setState('images', false);
					@unlink($images[0]['path']);
					Yii::app()->user->setState('uploadImgId', $img->id);
					return $img->id;
				}
			}

		}
		return 0;
	}

	//将临时文件夹中的文件永久保存到上传文件夹中
	private function moveImageToUploadDir($image){
		$fileContent = file_get_contents($image['path']);
		$subDir = substr($image['filename'], 0, 2);
		//echo Yii::app()->params['uploadFileStorePath'].$subDir;exit;
		if(!is_dir(Yii::app()->params['uploadFileStorePath'].$subDir)){
			mkdir(Yii::app()->params['uploadFileStorePath'].$subDir);
		}
		$result = file_put_contents(Yii::app()->params['uploadFileStorePath'].$subDir.'/'.$image['filename'], $fileContent);
		if($result){
			return $subDir.'/'.$image['filename'];
		}else{
			throw new CException('moveImageToUploadDir error');
		}
	}

}