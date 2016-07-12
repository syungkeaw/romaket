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

                '<server:eden>/<controller>' => 'eden/<controller>/index',
                '<server:eden>/<controller>/<action:\w*>' => 'eden/<controller>/<action>',
                '<server:thor>/<controller>' => 'thor/<controller>/index',
                '<server:thor>/<controller>/<action:\w*>' => 'thor/<controller>/<action>',
                '<server:loki>/<controller>' => 'loki/<controller>/index',
                '<server:loki>/<controller>/<action:\w*>' => 'loki/<controller>/<action>',

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
                    'clientId'     => '474327099373950',
                    'clientSecret' => '9917a1e5591b8e1cda02e22d89f9cd9f',
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
