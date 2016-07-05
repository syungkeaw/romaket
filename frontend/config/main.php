<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
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
        'request'=>[
            'class' => 'common\classes\Request',
            'web'=> '/frontend/web'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // '/user/register' => '/user/registration/register',
                // '/user/resend' => '/user/registration/resend',
                // '/user/forgot' => '/user/recovery/request',
                // '/user/login' => '/user/security/login',
                // '/user/logout' => '/user/security/logout',

                '<controller:\w+>/<id:\d+>/<name:.+>' => '<controller>/index',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'authClientCollection' => [
            'class' => yii\authclient\Collection::className(),
            'clients' => [
                'facebook' => [
                    'class'        => 'dektrium\user\clients\Facebook',
                    'clientId'     => '739785062828151',
                    'clientSecret' => '80a1d1ab17182a3afd03f2485ece6b10',
                    'viewOptions' => ['popupWidth' => 1024, 'popupHeight' => 860,]  
                ],
                // 'twitter' => [
                //     'class'          => 'dektrium\user\clients\Twitter',
                //     'consumerKey'    => 'CONSUMER_KEY',
                //     'consumerSecret' => 'CONSUMER_SECRET',
                // ],
                // 'google' => [
                //     'class'        => 'dektrium\user\clients\Google',
                //     'clientId'     => 'CLIENT_ID',
                //     'clientSecret' => 'CLIENT_SECRET',
                // ],
            ],
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'enableFlashMessages' => false,
            // 'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin'],
            'controllerMap' => [
                'registration' => [
                    'class' => \dektrium\user\controllers\RegistrationController::className(),
                    'on ' . \dektrium\user\controllers\RegistrationController::EVENT_AFTER_REGISTER => function ($e) {
                        Yii::$app->response->redirect(array('/user/login'))->send();
                        Yii::$app->end();
                    }
                ],
            ],
        ],
    ],
    'params' => $params,
];
