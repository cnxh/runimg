<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - 联系我们';
$this->breadcrumbs=array(
	'联系我们',
);
?>
<?php if(Yii::app()->user->hasFlash('success')): ?>

    <?php
    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'×', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
        ),
    ));
    ?>

<?php else: ?>
	<?php /** @var BootActiveForm $form */
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'horizontalForm',
		'type'=>'horizontal',
	)); ?>

	<fieldset>

		<legend>联系我们</legend>

		<?php echo $form->textFieldRow($model, 'name'); ?>

		<?php echo $form->textFieldRow($model, 'email'); ?>

		<?php echo $form->textFieldRow($model, 'subject'); ?>


		<?php echo $form->textAreaRow($model, 'body', array('class'=>'span8', 'rows'=>5)); ?>



		<?php if(CCaptcha::checkRequirements()): ?>
			<?php echo $form->captchaRow($model, 'verifyCode'); ?>

		<?php endif; ?>


	</fieldset>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'提交')); ?>
	</div>

	<?php $this->endWidget(); ?>

<?php endif; ?>