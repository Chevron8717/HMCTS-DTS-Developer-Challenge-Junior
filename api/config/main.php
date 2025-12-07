<?php

/**
 * Main configuration file for both web and console applications.
 */

declare(strict_types=1);

use app\services\TaskService;

$config = [
    'id' => 'hmcts-dts-tasks-api',
    'name' => 'HMCTS DTS Tasks API',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => getenv('DB_DSN'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'enableSchemaCache' => YII_ENV === 'prod',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/error.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'logFile' => '@runtime/logs/info.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace'],
                    'logFile' => '@runtime/logs/debug.log',
                ],
            ],
        ],
    ],
    'container' => [
        'definitions' => [
            TaskService::class => [
                'class' => TaskService::class,
            ],
        ],
    ],
];

if (YII_ENV_DEV && YII_DEBUG) {
    // Configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];

    $config['aliases']['@bower'] = '@vendor/bower-asset';
}

return $config;
