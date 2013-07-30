<?php
/**
 * File: ImgController.php
 * User: xiahao
 * Date: 13-7-10
 * Time: 下午1:15
 * Email: do.not.reply@foxmail.com
  */

class ImgController extends Controller{

	public function actionUpload(){
        //Yii::app( )->user->setState( 'images', false);
        $model = new UploadForm();
		if(!empty($_POST['UploadForm'])){
            $model->attributes = $_POST['UploadForm'];
            $validate = $model->validate();
            if($validate){
				if($model->saveImg()){

				}else{
					throw new CHttpException(500, '服务器错误，请稍后再试');
				}
                //print_r(Yii::app( )->user->getState( 'images'));
            }
		}

		Yii::import( "xupload.models.XUploadForm" );
		$files = new XUploadForm;
		$this->render('upload', array(
			'model'=>$model,
			'files'=>$files
		));
	}


	/**
	 * 处理上传图片
	 */
	public function actionDoUpload( ) {
		Yii::import( "xupload.models.XUploadForm" );
		//This is for IE which doens't handle 'Content-type: application/json' correctly
		header( 'Vary: Accept' );
		if( isset( $_SERVER['HTTP_ACCEPT'] )
			&& (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
			header( 'Content-type: application/json' );
		} else {
			header( 'Content-type: text/html' );
		}

		//Here we check if we are deleting and uploaded file
		if( isset( $_GET["_method"] ) ) {
			if( $_GET["_method"] == "delete" ) {
				$file = empty($_GET["file"]) ? '' : trim($_GET['file']);
				if(preg_match("/^\w+\.\w+$/i", $file)) {
					$images = Yii::app()->user->getState('images');
					if(is_array($images) && !empty($images)){
						//delete & unlink image from user's session
						$newImages = array();
						foreach($images as $key => $image){
							if($image['filename'] != $file){
								$newImages[$key] = $image;
							}else{
								@unlink( $image['path'] );
							}
						}
						//update the user's image session
						$images = Yii::app()->user->setState('images', $newImages);
					}
				}
				echo json_encode( true );
			}
		} else {
			$model = new XUploadForm;
			$model->file = CUploadedFile::getInstance( $model, 'file' );
			//We check that the file was successfully uploaded
			if( $model->file !== null ) {
				//Here we define the paths where the files will be stored temporarily
				$path = realpath(Yii::app( )->getBasePath())."/../../tmp_uploads/";

				$publicPath = Yii::app( )->getBaseUrl( )."/tmp_uploads/";


				//Grab some data
				$model->mime_type = $model->file->getType( );
				$model->size = $model->file->getSize( );
				$model->name = $model->file->getName( );
				//(optional) Generate a random name for our file
				$filename = md5( Yii::app( )->user->id.microtime( ).$model->name);
				$filename .= ".".$model->file->getExtensionName( );

				$publicUrl = Yii::app()->createUrl('img/tmp', array('file'=>$filename));

				if( $model->validate( ) ) {
					//Move our file to our temporary dir
					$model->file->saveAs( $path.$filename );
					chmod( $path.$filename, 0777 );
					//here you can also generate the image versions you need
					//using something like PHPThumb


					//Now we need to save this path to the user's session
					/*if( Yii::app( )->user->hasState( 'images' ) ) {
						$userImages = Yii::app( )->user->getState( 'images' );
					} else {
						$userImages = array();
					}*/
                    $userImages = array();
					$userImages[] = array(
						"filename" => $filename,
						"path" => $path.$filename,//$path.$filename,
						'size' => $model->size,
						'mime' => $model->mime_type,
						'name' => $model->name,
						//url
						"url" => $publicUrl,
						"thumbnail_url" => $publicUrl,
					);
					Yii::app( )->user->setState( 'images', $userImages );

					//Now we need to tell our widget that the upload was succesfull
					//We do so, using the json structure defined in
					// https://github.com/blueimp/jQuery-File-Upload/wiki/Setup
					echo json_encode( array( array(
						"name" => $model->name,
						"type" => $model->mime_type,
						"size" => $model->size,
						"url" => $publicUrl,
						"thumbnail_url" => $publicUrl,
						"delete_url" => $this->createUrl( "doUpload", array(
							"_method" => "delete",
							"file" => $filename
						) ),
						"delete_type" => "POST"
					) ) );
				} else {
					//If the upload failed for some reason we log some data and let the widget know
					echo json_encode( array(
						array( "error" => $model->getErrors( 'file' ),
						) ) );
					Yii::log( "XUploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
						CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction"
					);
				}
			} else {
				throw new CHttpException( 500, "Could not upload file" );
			}
		}
	}

	/**
	 * 用户上传图片后 临时的图片地址
	 */
	public function actionTmp(){
		$fileName = Yii::app()->request->getParam('file');
		$images = Yii::app()->user->getState('images');
		if(!empty($images) &&is_array($images)){
			foreach($images as $image){
				if($image['filename'] == $fileName){
					header("Pragma: public");
					header("Expires: 0");
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
					header("Content-Type: {$image['mime']}");
					header("Content-Length: ".$image['size']);
					@readfile($image['path']);
					break;
				}
			}

		}
	}

	public function actionGet(){
		$hashCode = $_GET['hash_code'];
		$ext = $_GET['ext'];
		$cache = Yii::app()->cache;
		$img = $cache->get($hashCode);
		if($img === false){//缓存不存在  查数据库
			$model = Img::model()->find('hash_code = :hash_code', array(':hash_code' => $hashCode));
			if(empty($model)){
				header("HTTP/1.0 404 Not Found");
				Yii::app()->end();
			}else{
				$cacheExpireTime = $model->expire_time > time() ? $model->expire_time - time() : 72000;//文件过期后直接指定cache时间
				$img = serialize($model);
				$cache->set($hashCode, $img, $cacheExpireTime);
			}
		}

		//now show the img
		$img = unserialize($img);
		if ($img->status && $img->start_time < time() && $img->expire_time > time()) { //正常时 展示图片
			header("Content-type: $img->mime");
			header("Content-Length: " . $img->size);
			header("Cache-Control: maxage=" . ($img->expire_time - time()));
			$content = $cache->get('content_' . $hashCode);
			if ($content === false) {
				$content = @file_get_contents(Yii::app()->params['uploadFileStorePath'] . $img->file_path);
				$cache->set('content_' . $hashCode, $content);
			}
			echo $content;
		} else { //异常时间 显示错误
			header("HTTP/1.0 404 Not Found");
		}

	}

    public function actionText(){
      // $content = Yii::app()->session->get('aaa');
        $content = false;
        if($content !== false){
            $this->renderPartial('_textPreview', array('content'=>$content));exit;
        }
        if(!empty($_POST)){

            //$this->renderPartial('_textPreview', array('content'=>($_POST['TextForm']['content'])));exit;
            $content = $this->renderPartial('_textPreview', array('content'=>($_POST['TextForm']['content'])), true);
           // Yii::app()->session->set('aaa', $content);
            //Yii::app()->redirect();
            //var_dump($_POST);EXIT;
            //$html2pdf = Yii::app()->ePdf->HTML2PDF();
           //$html2pdf->SetDefaultFont('msyh');
            //$html2pdf->WriteHTML($content);

            //$html2pdf->Output();

           //$mPDF1 = Yii::app()->ePdf->mpdf();

            # You can easily override default constructor's params
           // $mPDF1 = Yii::app()->ePdf->mpdf('', 'A5');

            # render (full page)
           // $mPDF1->WriteHTML($this->render('index', array(), true));

            # Load a stylesheet
           // $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
           // $mPDF1->WriteHTML($stylesheet, 1);

            # renderPartial (only 'view' of current controller)
           // $mPDF1->WriteHTML($this->renderPartial('index', array(), true));

            # Renders image
            //$mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));
            //$mPDF1->SetAutoFont(AUTOFONT_ALL);
           //$mPDF1->WriteHTML($content);
            # Outputs ready PDF
           // $mPDF1->Output();
        }
        $model = new TextForm;
        $this->render('text', array('model'=>$model));
    }
}
?>