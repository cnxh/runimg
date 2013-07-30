<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="container">
<?php $this->widget('bootstrap.widgets.TbNavbar', array(
	'type'=>'inverse', // null or 'inverse'
	'brand'=>Yii::app()->name,
	'brandUrl'=>array('/site/index'),
	'fluid'=>false,
	'collapse'=>false, // requires bootstrap-responsive.css
	'items'=>array(
		array(
			'class'=>'bootstrap.widgets.TbMenu',
			'items'=>array(
				array('label'=>'首页', 'url'=>array('/site/index')),
				array('label'=>'上传图片', 'url'=>array('/img/upload')),
				//array('label'=>'文字转换图片', 'url'=>array('/img/text')),
				array('label'=>'其他', 'url'=>'#', 'items'=>array(
					array('label'=>'关于', 'url'=>array('/site/page', 'view'=>'about'), 'active'=>false),
					array('label'=>'联系我们', 'url'=>array('/site/contact'), 'active'=>false),
					array('label'=>'服务条款', 'url'=>array('/site/page', 'view'=>'service'), 'active'=>false),
				)),
			),
		),
		/*'<form class="navbar-search pull-left" action=""><input type="text" class="search-query span2" placeholder="Search"></form>',*/
		array(
			'class'=>'bootstrap.widgets.TbMenu',
			'htmlOptions'=>array('class'=>'pull-right'),
			'items'=>array(
				array('label'=>Yii::app()->user->name, 'url'=>'#', 'items'=>array(
					array('label'=>'Action', 'url'=>'#'),
					array('label'=>'Another action', 'url'=>'#'),
					array('label'=>'Something else here', 'url'=>'#'),
					'---',
					array('label'=>'退出', 'url'=>array('/site/logout')),
				),'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'注册', 'url'=>array('/site/register'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'登陆', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
			),

		),
	),
)); ?>
</div>
<div class="clear"></div>
<div class="container" >
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>
</div>
<div class="clear"></div>
<div class="container">
	<div class="well">
		Copyright &copy; <?php echo date('Y'); ?> by Runimg.com.<br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->
</div>
<div style="display:none;"><script src="http://s25.cnzz.com/stat.php?id=5495992&web_id=5495992" language="JavaScript"></script></div>
</body>
</html>
