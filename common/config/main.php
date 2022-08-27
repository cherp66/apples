<?php
return [
    'bootstrap' => [
        'log',
        'gii'
    ],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
        ]
    ],
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
    ],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
];
