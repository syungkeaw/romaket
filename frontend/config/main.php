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
        // 'user' => [
        //     'identityClass' => 'common\models\User',
        //     'enableAutoLogin' => true,
        // ],
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'authClientCollection' => [
            'class' => yii\authclient\Collection::className(),
            'clients' => [
                'facebook' => [
                    'class'        => 'dektrium\user\clients\Facebook',
                    'clientId'     => '474331226040204',
                    'clientSecret' => '23998583a8903bd071ba0acc3ee1db33',
                ],
                'twitter' => [
                    'class'          => 'dektrium\user\clients\Twitter',
                    'consumerKey'    => 'CONSUMER_KEY',
                    'consumerSecret' => 'CONSUMER_SECRET',
                ],
                'google' => [
                    'class'        => 'dektrium\user\clients\Google',
                    'clientId'     => 'CLIENT_ID',
                    'clientSecret' => 'CLIENT_SECRET',
                ],
            ],
        ],
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            // 'enableUnconfirmedLogin' => true,
            'enableFlashMessages' => false,
            // 'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin'],
        ],
    ],
    'params' => $params,
];
