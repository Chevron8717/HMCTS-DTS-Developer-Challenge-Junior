<?php

/**
 * Bootstrap file for the API application.
 */

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$yiiEnv = getenv('YII_ENV');

defined('YII_DEBUG') or define('YII_DEBUG', getenv('YII_DEBUG') === 'true');
defined('YII_ENV') or define('YII_ENV', $yiiEnv !== false ? $yiiEnv : 'prod');

if (YII_ENV === 'dev') {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

if (!class_exists('Yii')) {
    require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
}
