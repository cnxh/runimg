<?php
/**
 * File: _success.php
 * User: xiahao
 * Date: 13-7-11
 * Time: 下午5:03
 * Email: do.not.reply@foxmail.com
  */
$id = Yii::app()->user->getState('uploadImgId');
$img = Img::model()->findByPk($id);
$extension = substr($img->mime, strpos($img->mime, '/')+1);
$imgUrl = Yii::app()->createUrl('img/get', array('hash_code'=>$img->hash_code,'ext'=>$extension));
$expireTime = date('Y-m-d H:i:s', $img->expire_time);
$startTime =  $img->start_time == 0 ? '立刻生效' : date('Y-m-d H:i:s', $img->start_time);
$html = <<<EOF
<h2>上传成功！复制下面的地址到你需要引用的地方吧</h2>
<p>图片引用地址:
	<input type="text" value="{$imgUrl}" style="width:400px"/>
	<a class="btn btn-success btn-small" href="{$imgUrl}" target=_blank>查看外链图片</a>
</p>
<p>图片开始生效时间: {$startTime}</p>
<p>图片过期删除时间: {$expireTime}</p>
EOF;

Yii::app()->user->setFlash('success', $html);
$this->widget('bootstrap.widgets.TbAlert', array(
	'block'=>true, // display a larger alert block?
	'fade'=>true, // use transitions?
	'closeText'=>'', // close link text - if set to false, no close link is displayed
	'alerts'=>array( // configurations per alert type
		'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>''), // success, info, warning, error or danger
	),
));
Yii::app()->user->setState('uploadImgId', false);

?>