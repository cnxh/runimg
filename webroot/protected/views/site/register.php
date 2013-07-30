<?php
$this->pageTitle=Yii::app()->name . ' - 注册';
$this->breadcrumbs=array(
	'注册',
);
?>



<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'horizontalForm',
	'type'=>'horizontal',
)); ?>

<fieldset>

	<legend>注册</legend>

	<?php echo $form->textFieldRow($model, 'email'); ?>
	<?php echo $form->textFieldRow($model, 'nickName'); ?>
	<?php echo $form->passwordFieldRow($model, 'password'); ?>
	<?php echo $form->passwordFieldRow($model, 'rePassword'); ?>

	<?php echo $form->toggleButtonRow(
		$model,
		'applyTermsService',
		array(
			'hint' => '请选择是否同意并接受《'.CHtml::link('服务协议',array('site/page','view'=>'service'),array('target'=>'_blank')).'》',
			'options' => array(
				'enabledLabel'=>'是',
				'disabledLabel'=>'否'
			)
		)
	); ?>


</fieldset>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'注册')); ?>
</div>

<?php $this->endWidget(); ?>
