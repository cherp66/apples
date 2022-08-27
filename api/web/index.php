<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: authorization');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Request-Method: OPTIONS, POST, GET');
header('Access-Control-Max-Age: 3600');
header('Origin: *');
header('Access-Control-Request-Headers: *');

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';

    $config = yii\helpers\ArrayHelper::merge(
        require __DIR__ . '/../../common/config/main.php',
        require __DIR__ . '/../../common/config/main-local.php',
        require __DIR__ . '/../config/main.php',
    );

(new yii\web\Application($config))->run();
