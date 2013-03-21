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
		/* MODULE 'yii-user-management'
		 * 'user' => array(
			'debug' => false,
			'usersTable' => 'user',
			'translationTable' => 'translation',
			'textSettingsTable' => 'yumtextsettings',
		),
		'usergroup' => array(
			'usergroupTable' => 'user_group',
			'usergroupMessagesTable' => 'user_group_message',
		),
		'membership' => array(
			'membershipTable' => 'membership',
			'paymentTable' => 'payment',
		),
		'friendship' => array(
			'friendshipTable' => 'friendship',
		),
		'profile' => array(
			'privacySettingTable' => 'privacy_setting',
			'profileFieldsGroupTable' => 'profile_field_group',
			'profileFieldsTable' => 'profile_field',
			'profileTable' => 'profile',
			'profileCommentTable' => 'profile_comment',
			'profileVisitTable' => 'profile_visit',
		),
		'role' => array(
			'rolesTable' => 'role',
			'userHasRoleTable' => 'user_role',
			'actionTable' => 'action',
			'permissionTable' => 'permission',
		),
		'registration' => array(
		),
		'messages' => array(
			'messagesTable' => 'message',
		),*/
		//'gii'=>array(
		//	'class'=>'system.gii.GiiModule',
		//	'password'=>'giitest',
		//	'generatorPaths'=>array(
		//		'bootstrap.gii'
		//	),
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
		//	'ipFilters'=>array('127.0.0.1','::1','10.10.1.103', '10.10.2.2', '10.10.2.3'),
		//),
	),

	// application components
	'components'=>array(
            'user'=>array(
                'class' => 'WebUser',
                'allowAutoLogin'=>true,
            ),
            /* MODULE 'yii-user-management'
            'user'=>array(
                // enable cookie-based authentication
                'allowAutoLogin'=>true,
                'class' => 'application.modules.user.components.YumWebUser',
                'allowAutoLogin'=>true,
                'loginUrl' => array('//user/user/login'),
            ),
             */
            'authManager' => array(
                'class' => 'PhpAuthManager',
                'defaultRoles' => array('guest'),
            ),
            
            // uncomment the following to enable URLs in path-format
            'urlManager'=>array(
                'urlFormat'=>'path',
                'showScriptName' => false,
                'rules'=>array(
                    //'page/<view:\w+>'=>'site/page',
                    '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                    'invitations/<token:[a-zA-Z0-9]+>'=>'invitations/view',
                    'user/activation/<key:\w+>'=>'user/activation',
                ),
            ),
        /*
            'db'=>array(
                    'connectionString' => 'mysql:host=localhost;dbname=testdrive',
                    'emulatePrepare' => true,
                    'username' => 'periodontal',
                    'password' => 'MASTodontic743',
                    'charset' => 'utf8',
                    'tablePrefix' => '',
            ),
        */
            'db2'=>array(
                    'class'=>'CDbConnection',
                    'connectionString' => 'pgsql:host=localhost;port=5432;dbname=peri',
                    'emulatePrepare' => true,
                    'username' => 'peri',
                    'password' => 'mason78rosy',
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
                    array( // configuration for the toolbar
                        'class'=>'XWebDebugRouter',
                        'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
                        'levels'=>'error, warning, trace, profile, info',
                        'allowedIPs'=>array('127.0.0.1','::1','192.168.1.54','192\.168\.1[0-5]\.[0-9]{3}', '10.10.2.2','10.10.2.3'),
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
