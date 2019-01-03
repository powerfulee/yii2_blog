<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
    	'admin' => [
            'class' => 'mdm\admin\Module',
             'layout' => 'left-menu',//yii2-admin�ĵ����˵�
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        "authManager" => [        
	        "class" => 'yii\rbac\DbManager', //����ǵ��õ����Ŷ�����˫����        
	        "defaultRoles" => ["guest"],    
    	],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,

            'rules' => [
            	"<controller:\w+>/<id:\d+>"=>"<controller>/view",
        		"<controller:\w+>/<action:\w+>"=>"<controller>/<action>",
        		'user/delete/<id:\d+>' => 'user/delete',
        		'user/add/<id:\d+>' => 'user/add',
        		'role/delete/<id:\d+>' => 'role/delete',
        		'role/add/<id:\d+>' => 'role/add',
        		'role/getMenuTree/<id:\d+>' => 'role/getMenuTree',
        		'category/add/<id:\d+>' => 'category/add',
        		'category/delete/<id:\d+>' => 'category/delete',
        		'blog/add/<id:\d+>' => 'blog/add',
        		'blog/delete/<id:\d+>' => 'blog/delete',
            ],
        ],
        'assetManager' => [
        	/*
		    'bundles' => [
		        'yii\web\JqueryAsset' => [
		            'js' => [],  // ȥ�� jquery.js
		            'sourcePath' => null,  // ��ֹ�� frontend/web/asset �������ļ�
		        ],
		        'yii\bootstrap\BootstrapAsset' => [
			         'css' => [],  // ȥ�� bootstrap.css
			         'sourcePath' => null, // ��ֹ�� frontend/web/asset �������ļ�
			     ],
			     'yii\bootstrap\BootstrapPluginAsset' => [
			         'js' => [],  // ȥ�� bootstrap.js
			         'sourcePath' => null,  // ��ֹ�� frontend/web/asset �������ļ�
			     ],
		    ],
		    */
		],
    ],
    'as access' => [
	    'class' => 'mdm\admin\components\AccessControl',
	    'allowActions' => [
	        //������������ʵ�action
	        //controller/action
	        '*'
	    ]
	],
    'params' => $params,
];
