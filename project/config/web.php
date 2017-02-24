<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'yii2-test-blog',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '_vznheOWJVp1rgw3gqB_zpIf0xONW0Se',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'auth\components\User',
            'identityClass' => 'auth\models\User', // or replace to your custom identityClass
            'enableAutoLogin' => true,
            'loginUrl' => ['user/default/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'main/default/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'authManager' => [
            'class' => '\yii\rbac\DbManager',
            'ruleTable' => 'AuthRule', // Optional
            'itemTable' => 'AuthItem',  // Optional
            'itemChildTable' => 'AuthItemChild',  // Optional
            'assignmentTable' => 'AuthAssignment',  // Optional
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'main/default/index',
                'contact' => 'main/contact/index',
                'login' => 'user/default/login',
                'signup' => 'user/default/signup',
                '<_a:error>' => 'main/default/<_a>',
                '<_a:(login|logout)>' => 'user/default/<_a>',

                '<_m:[\w\-]+>' => '<_m>/default/index',
                '<_m:[\w\-]+>/<_c:[\w\-]+>' => '<_m>/<_c>/index',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/view',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/<_a>',
            ],
        ],
    ],
    'params' => $params,
    'modules' => [
        'main' => [
            'class' => 'app\modules\main\Module',
        ],
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
        'auth' => [
            'class' => 'auth\Module',
            'layout' => '//homepage', // Layout when not logged in yet
            'layoutLogged' => '//main', // Layout for logged in users
            'attemptsBeforeCaptcha' => 3, // Optional
            'supportEmail' => 'killbond@mail.ru', // Email for notifications
            'passwordResetTokenExpire' => 3600, // Seconds for token expiration
            'superAdmins' => ['admin'], // SuperAdmin users
            'tableMap' => [ // Optional, but if defined, all must be declared
                'User' => 'user',
                'UserStatus' => 'user_status',
                'ProfileFieldValue' => 'profile_field_value',
                'ProfileField' => 'profile_field',
                'ProfileFieldType' => 'profile_field_type',
            ],
        ],
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.56.1'],
    ];
}

return $config;
