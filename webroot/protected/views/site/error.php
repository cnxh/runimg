<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - 错误';
$this->breadcrumbs=array(
	'错误',
);
?>

<h2>错误 <?php echo $code; ?></h2>

<?php
Yii::app()->user->setFlash('error', CHtml::encode($message));
$this->widget('bootstrap.widgets.TbAlert', array(
	'block'=>true, // display a larger alert block?
	'fade'=>true, // use transitions?
	'closeText'=>'×', // close link text - if set to false, no close link is displayed
	'alerts'=>array( // configurations per alert type
		'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>''), // success, info, warning, error or danger
	),
));

?>