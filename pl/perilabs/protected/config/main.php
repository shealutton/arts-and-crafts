<?php
defined('YII_DEBUG') or define('YII_DEBUG',false);
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
function _joinpath($dir1, $dir2) {
    return realpath($dir1 . '/' . $dir2);
}
 
$homePath      = dirname(__FILE__) . '/../..';
$protectedPath = _joinpath($homePath, 'protected');
$webrootPath   = _joinpath($homePath, 'perilabs');
$runtimePath   = _joinpath($homePath, 'runtime');
$uploadPath    = _joinpath($homePath, '../data/uploads');
Yii::setPathOfAlias('uploads', $uploadPath);
define('HOSTED',true);

return array(
	'basePath'=>$protectedPath,//dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'runtimePath'=>$runtimePath,
	'name'=>'Peri Labs',
	'theme'=>'perilabs',
	// preloading 'log' component
	'preload'=>array(
		'log',
		'bootstrap'
	),
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.user.models.*',
		'application.extensions.yiidebugtb.*',
        	'application.extensions.CAdvancedArBehavior',
        	'application.extensions.yii-mail.*',
        	'application.extensions.PHPExcel.*',
        	'application.extensions.*'
	),
	'modules'=>array(
	),
	// application components
	'components'=>array(
            'user'=>array(
                'class' => 'WebUser',
                'allowAutoLogin'=>true,
            ),
            'authManager' => array(
                'class' => 'PhpAuthManager',
                'defaultRoles' => array('guest'),
            ),
            // uncomment the following to enable URLs in path-format
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName' => false,
                'rules'=>array(
                    'invitations/<token:[a-zA-Z0-9]+>'=>'invitations/view',
                    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                    'user/activation/<key:\w+>'=>'user/activation',
                ),
            ),
            'db2'=>array(
                    'class'=>'CDbConnection',
                    'connectionString' => 'pgsql:host=localhost;port=5432;dbname=peri',
                    'emulatePrepare' => true,
                    'username' => 'peri',
                    'password' => 'devel89PONDER',
                    'charset' => 'utf8',
                    'tablePrefix' => '',
            ),
            'excel' => array(
                    'class' => 'application.extensions.PHPExcel',
            ),
            'errorHandler'=>array(
                // use 'site/error' action to display errors
                'errorAction'=>'site/error',
            ),
            'bootstrap'=>array(
            'class'=>'ext.bootstrap.components.Bootstrap',
            'coreCss'=>true,
            'responsiveCss'=>true,
            'plugins'=>array(
                'transition'=>true,
                'carousel'=>true,
                'navbar'=>true,
                'tooltip'=>array(
                    'selector'=>'a.tooltip',
                    'options'=>array(
                        'placement'=>'top'
                    )
                )
            )
            ),
            'mail' => array(
                'class' => 'ext.yii-mail.YiiMail',
                'transportType' => 'php',
                'viewPath' => 'application.views.mail',
                'logging' => true,
                'dryRun' => false
            ),
            'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'error, warning',
                    ),
                ),
            ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'support@perilabs.com',
		'homePath'=>$homePath,
		'webrootPath'=>$webrootPath,
		'uploadPath'=>$uploadPath,
		'defaultPageSize'=>25,
		'data_type_storage'=>array(
			1 => array(
				'metric_class_name'=> 'MBool',
				'metric_table_suffix'=>'m_bool',
				'variable_class_name'=> 'VBool',
				'variable_table_suffix'=>'v_bool'
			),
			2 => array(
				'metric_class_name'=> 'MInt',
				'metric_table_suffix'=>'m_int',
				'variable_class_name'=> 'VInt',
				'variable_table_suffix'=>'v_int'
			),
			3 => array(
				'metric_class_name'=> 'MReal',
				'metric_table_suffix'=>'m_real',
				'variable_class_name'=> 'VReal',
				'variable_table_suffix'=>'v_real'
			),
			4 => array(
				'metric_class_name'=> 'MText',
				'metric_table_suffix'=>'m_text',
				'variable_class_name'=> 'VText',
				'variable_table_suffix'=>'v_text'
			),
			6 => array(
				'metric_class_name'=> 'MTime',
				'metric_table_suffix'=>'m_time',
				'variable_class_name'=> 'VTime',
				'variable_table_suffix'=>'v_time'
			),
		), // /data_type_storage
		'handlers'=>array( // maps mime types to controller sub-actions
		    'documents'=>array( // Model name
		        'view'=>array( // Controller action
		            'text/html'=>'render html',
		            'text/plain'=>'render html',
		        ),
		        'update'=>array( // Controller action
		            'text/html'=>'edit html',
		            'text/plain'=>'edit html',
		        ),
		        'create'=>array( // Controller action
		            'text/html'=>'create html',
		            'text/plain'=>'create html',
		        ),
		    ),// /Documents
		), // /subactions
	), // /params
);// fin
