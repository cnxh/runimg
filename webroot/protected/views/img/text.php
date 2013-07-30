<?php

$this->pageTitle=Yii::app()->name . ' - 文字转换图片';
$this->breadcrumbs=array(
	'文字转换图片',
);
?>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
    //'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
    'clientOptions'=>array(
        'validateOnSubmit'=>false,
    ),
));
?>
<?php
$this->widget('ext.wdueditor.WDueditor',array(
    'model' => $model,
    'attribute' => 'content',
    'width' =>'100%',
    'height' =>'300',
    'editorOptions'=>array(
        //'focus'=>true,
        'autoClearinitialContent'=>true,
        'elementPathEnabled'=>false,

    ),
    'toolbars' =>array(

    ),
));

?>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton',
            array(
                'buttonType'=>'submit',
                'type'=>'primary',
                'label'=>'预览图片',
            )); ?>
    </div>

<?php
$this->endWidget();
?>