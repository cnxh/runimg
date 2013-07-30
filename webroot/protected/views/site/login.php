<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 登录';
$this->breadcrumbs=array(
	'登录',
);
?>


<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'horizontalForm',
	'type'=>'horizontal',
)); ?>

<fieldset>

	<legend>登录</legend>

	<?php echo $form->textFieldRow($model, 'username'); ?>
	<?php echo $form->passwordFieldRow($model, 'password'); ?>
	<?php echo $form->checkBoxRow($model, 'rememberMe'); ?>


</fieldset>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'登录')); ?>
</div>

<?php $this->endWidget(); ?>

