<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'language'=>'zh-CN',
    'timeZone' => 'Asia/Phnom_Penh',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'xfmN-l2_ZqCqitr6YvAehMvc8btD6mLC',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\login\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'maxSourceLines' => 20,
//            'errorAction' => 'home/main/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'officeaction2017@gmail.com',
                'password' => 'Officeaction123',
                'port' => '25',
                'encryption' => 'tls',
            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['officeaction2017@gmail.com'=>'OA']
            ],
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
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],

        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null, //通常都要重置为null，
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'css' => [
                        'css/global/bootstrap.min.css?v=3.3.6', //改成你要用的web输出地址
                    ],
                    'js' => [
                        'js/global/bootstrap.min.js?v=3.3.6', //改成你要用的web输出地址
                    ]
                ],
            ],
        ],

    ],
    'params' => $params,

//    'defaultRoute' => 'home', //默认控制器
    'modules'=>[
        'customer'=>[
            'class' => 'app\modules\customer\Module'
        ],
        'finance'=>[
            'class' => 'app\modules\finance\Module'
        ],
        'home'=>[
            'class' => 'app\modules\home\Module'
        ],
        'login'=>[
            'class' => 'app\modules\login\Module'
        ],
        'notice'=>[
            'class' => 'app\modules\notice\Module'
        ],
        'product'=>[
            'class' => 'app\modules\product\Module'
        ],
        'task'=>[
            'class' => 'app\modules\task\Module'
        ],
        'user'=>[
            'class' => 'app\modules\user\Module'
        ],
        'system'=>[
            'class' => 'app\modules\system\Module'
        ],
    ],

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
