<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

?>
<?php $this->beginWidget('bootstrap.widgets.TbHeroUnit', array(
	'heading'=>'RunImg!',
	'htmlOptions'=>array('style'=>'margin-top:60px;'),
)); ?>

 <p> RunImg提供一种完全免费的创新图片托管服务。您将RunImg托管的图片发布到任意网站上后，通过RunImg，您还保留有这些图片的全部控制权，您可以在任意时间修改图片、使图片过期、甚至设置图片只能在指定的地区打开。</p>
<p>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'type'=>'primary',
		'size'=>'large',
		'label'=>'免费使用',
		'url'=>array('img/upload'),
	)); ?>

	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'type'=>'info',
		'size'=>'large',
		'label'=>'了解更多',
		'url'=>array('site/page','view'=>'about'),
		'htmlOptions'=>array('style'=>'margin-left:20px')
	)); ?>
</p>

<?php $this->endWidget(); ?>

<?php
$this->widget('bootstrap.widgets.TbBox', array(
	'title' => '合作伙伴',
	'headerIcon' => '',
	//'content' => 'My Basic Content (you can use renderPartial here too :))' // $this->renderPartial('_view')
	'content' => $this->renderPartial('_hezuo')
));
?>
