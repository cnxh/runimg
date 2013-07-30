<!-- The file upload form used as target for the file upload widget -->
<?php if ($this->showForm) echo CHtml::beginForm($this -> url, 'post', $this -> htmlOptions);?>
<div class="row fileupload-buttonbar">
	<div class="span3">
		<!-- The fileinput-button span is used to style the file input field as button -->
		<span class="btn btn-success fileinput-button">
            <i class="icon-plus icon-white"></i>
            <span><?php echo $this->t('1#添加文件|0#选择文件', $this->multiple); ?></span>
			<?php
            if ($this -> hasModel()) :
                echo CHtml::activeFileField($this -> model, $this -> attribute, $htmlOptions) . "\n";
            else :
                echo CHtml::fileField($name, $this -> value, $htmlOptions) . "\n";
            endif;
            ?>
		</span>
        <?php if ($this->multiple) { ?>
		<button type="submit" class="btn btn-primary start">
			<i class="icon-upload icon-white"></i>
			<span>开始上传</span>
		</button>
		<button type="reset" class="btn btn-warning cancel">
			<i class="icon-ban-circle icon-white"></i>
			<span>取消上传</span>
		</button>
		<button type="button" class="btn btn-danger delete">
			<i class="icon-trash icon-white"></i>
			<span>删除</span>
		</button>
		<input type="checkbox" class="toggle">
        <?php } ?>
	</div>
	<div class="span5">
		<!-- The global progress bar -->
		<div class="progress progress-success progress-striped active fade">
			<div class="bar" style="width:0%;"></div>
		</div>
	</div>
</div>
<div class="controls">
	<!-- The loading indicator is shown during image processing -->
	<div class="fileupload-loading">


	</div>
	<!-- The table listing the files available for upload/download -->
	<table class="table table-striped">
		<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
        <?php
        $images = Yii::app()->user->getState('images');
        if(!empty($images) && is_array($images)){
            foreach($images as $key=>$image){
				$deleteUrl = Yii::app()->createUrl('img/doUpload', array('_method'=>'delete', 'file'=>$image['filename']));
                echo <<<EOF
 <tr class="template-download fade in" style="height: 102px;">

            <td class="preview" style="width:100px;height:100px;overflow:hidden">
                <img src="{$image['url']}" title="">
            </td>
            <td class="name">
                {$image['name']}
            </td>
            <td class="size"><span>{$image['size']}</span></td>
            <td colspan="2"></td>

            <td class="delete">
                <button class="btn btn-danger" data-type="POST" data-url="{$deleteUrl}">
                    <i class="icon-trash icon-white"></i>
                    <span>删除</span>
                </button>
                <input type="hidden" name="delete" value="{$key}">
            </td>
        </tr>
EOF;

            }
        }
        ?>

		</tbody>
	</table>
</div>

<?php if ($this->showForm) echo CHtml::endForm();?>
