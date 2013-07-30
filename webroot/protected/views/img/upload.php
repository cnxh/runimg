<?php
/**
 * File: upload.php
 * User: xiahao
 * Date: 13-7-10
 * Time: 下午1:18
 * Email: do.not.reply@foxmail.com
  */
$this->pageTitle=Yii::app()->name . ' - 上传图片';
$this->breadcrumbs=array(
	'上传图片',
);
?>
<?php
if(Yii::app()->user->isGuest){
	Yii::app()->user->setFlash('warning', '您还未登录，'.CHtml::link('登录',array('site/login')).' 后更多定制功能可用(随时修改图片、设置图片失效后效果等)。 还没有账号? '.CHtml::link('点此注册', array('site/register')));
	$this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true, // display a larger alert block?
		'fade'=>true, // use transitions?
		'closeText'=>'×', // close link text - if set to false, no close link is displayed
		'alerts'=>array( // configurations per alert type
			'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
		),
	));
}

?>

<?php
if(Yii::app()->user->getState('uploadImgId')){
	$this->renderPartial('_success');
}

?>

<?php
$errorSummary = CHtml::errorSummary($model, '');
if(!empty($errorSummary)){
    Yii::app()->user->setFlash('error', $errorSummary);
    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>''), // success, info, warning, error or danger
        ),
    ));
}

?>

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'horizontalForm',
	'type'=>'horizontal',
	//'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'enableAjaxValidation'=>false,
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
)); ?>

	<fieldset>

		<legend>上传图片</legend>

			<label class="control-label required">图片文件<span class="required">*</span></label>
			<?php
			$this->widget('xupload.XUpload', array(
				'url' => Yii::app()->createUrl("img/doUpload"),
				'model' => $files,
				'attribute' => 'file',
				'multiple' => false,
				'autoUpload'=>true,
				'showForm'=>false,
				'htmlOptions' => array('id'=>'horizontalForm',"class"=>'controls' ),
			));
			?>

		<?php echo $form->dropDownListRow($model, 'startTime',
			UploadForm::$startTimeSet,
			array('hint'=>'在开始生效时间前，图片外链地址是处于失效状态的'));
		?>

		<?php
		echo $form->textFieldRow($model, 'startTimeInput',

			array('hint'=>'北京时间,格式如 '.date('Y-m-d H:i:s', time()))

		);
		?>

		<?php echo $form->dropDownListRow($model, 'expireTime',
			UploadForm::$expireTimeSet,
			array('hint'=>'图片将在过期时间后彻底删除，且无法恢复'));
		?>

		<?php
		echo $form->textFieldRow($model, 'expireTimeInput',

			array('hint'=>'北京时间,格式如 '.date('Y-m-d H:i:s', time()))

		);
		?>

		<label class="control-label required">接受协议<span class="required">*</span></label>
		<div class="controls">
		<?php
			 $this->widget(
				'bootstrap.widgets.TbToggleButton',
				array(
					'model' => $model,
					'attribute' => 'applyTermsService',
					'enabledLabel'=>'是',
					'disabledLabel'=>'否',
					//'htmlOptions' => array('class'=>"controls"),
				)
			);
		echo '<p class="help-block">请选择是否同意并接受《'.CHtml::link('服务协议',array('site/page','view'=>'service'),array('target'=>'_blank')).'》</p>';
		?>
		</div>

	</fieldset>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton',
			array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'生成外链地址',
			)); ?>
	</div>

<?php $this->endWidget(); ?>

<style type="text/css">
	.control-group.expireTimeInput {display: none}
</style>

<script type="text/javascript">
	$("#UploadForm_expireTime").change(function(){
		if($(this).val() == 0){
			$('.control-group.expireTimeInput').show();
		}else{
			$('.control-group.expireTimeInput').hide();
		}
	});
	$("#UploadForm_expireTime").trigger('change');

	$("#UploadForm_startTime").change(function(){
		if($(this).val() == 99){
			$('.control-group.startTimeInput').show();
		}else{
			$('.control-group.startTimeInput').hide();
		}
	});
	$("#UploadForm_startTime").trigger('change');
</script>