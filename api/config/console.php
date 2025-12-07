<?php

/**
 * Configuration file for the console application.
 */

declare(strict_types=1);

use yii\helpers\ArrayHelper;

$config = require __DIR__ . '/main.php';

/**
 * @psalm-suppress InvalidArgument
 * @see https://github.com/yiisoft/yii2/issues/20437
 */
return ArrayHelper::merge($config, [
    'controllerNamespace' => 'app\commands',
]);
