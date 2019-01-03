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
             'layout' => 'left-menu',//yii2-admin的导航菜单
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
	        "class" => 'yii\rbac\DbManager', //这里记得用单引号而不是双引号        
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
		            'js' => [],  // 去除 jquery.js
		            'sourcePath' => null,  // 防止在 frontend/web/asset 下生产文件
		        ],
		        'yii\bootstrap\BootstrapAsset' => [
			         'css' => [],  // 去除 bootstrap.css
			         'sourcePath' => null, // 防止在 frontend/web/asset 下生产文件
			     ],
			     'yii\bootstrap\BootstrapPluginAsset' => [
			         'js' => [],  // 去除 bootstrap.js
			         'sourcePath' => null,  // 防止在 frontend/web/asset 下生产文件
			     ],
		    ],
		    */
		],
    ],
    'as access' => [
	    'class' => 'mdm\admin\components\AccessControl',
	    'allowActions' => [
	        //这里是允许访问的action
	        //controller/action
	        '*'
	    ]
	],
    'params' => $params,
];
