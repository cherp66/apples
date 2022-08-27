<?php

return [
    'id' => 'application-api',
    'language' => 'ru',
    'name' => 'Apple',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
    ],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\modules\user\auth\Identity',
            'enableSession' => false
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/all.log',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                'POST   api/v1/create' => 'apple/create',
                'PUT    api/v1/fall'   => 'apple/fall',
                'PUT    api/v1/eat'    => 'apple/eat',
                'DELETE api/v1/delete' => 'apple/delete',
            ]
        ]
    ],
    'params' => require dirname(__DIR__, 2) .'/common/config/params.php',
    'vendorPath' => dirname(__DIR__, 2) .'/vendor',
];
