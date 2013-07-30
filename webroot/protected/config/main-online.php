<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'RunImg',

	// preloading 'log' component
	'preload'=>array('log','bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
	'aliases'=>array(
		'xupload' => 'ext.xupload'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		/*'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths' => array(
				'bootstrap.gii'
			),
		),*/

	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'bootstrap' => array(
			'class' => 'ext.yii-booster.components.Bootstrap',
			'responsiveCss' => true,
		),

		'cache'=>array(
			//'class'=>'system.caching.CFileCache',
			'class'=>'system.caching.CMemCache',
			'servers'=>array(
				array('host'=>'localhost', 'port'=>11211, 'weight'=>100),
			//	array('host'=>'server2', 'port'=>11211, 'weight'=>40),
			),
		),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'http://cn.runimg.com/<hash_code:\w+>.<ext:\w+>' => 'img/get',
				''=>'site/index',
				'upload'=>'img/upload',
				'text'=>'img/text',
				'page/<view:\w+>'=>'site/page',
				//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				//'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',

				'tmp/<file:.+>' => 'img/tmp',
				//'get/<file:\w+>'=>'tmp/<action>',
			),
		),

		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=runimg',
			'emulatePrepare' => true,
			'username' => 'runimg',
			'password' => 'runimg123456',
			'charset' => 'utf8',
			'schemaCachingDuration'=>720000,
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

        'mailSender'=>array(
            'class'=>'ext.sendcloud.ESendCloud',
            'sendCloudUsername'=>'postmaster@zjm.sendcloud.org',
            'sendCloudPassword'=>'081ClSdm',
			'sendCloudPathAlias'=>'ext.sendcloud',

        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'157000131@qq.com',
		'imageDomain'=>'http://cn.runimg.com',
		'uploadFileStorePath' => dirname(__FILE__).DIRECTORY_SEPARATOR .'..'.DIRECTORY_SEPARATOR .'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR
	),
);