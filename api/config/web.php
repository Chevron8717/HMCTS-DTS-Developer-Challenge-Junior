<?php

/**
 * Configuration file for the web application.
 */

declare(strict_types=1);

use yii\helpers\ArrayHelper;
use yii\web\Response;

$config = require __DIR__ . '/main.php';

return ArrayHelper::merge($config, [
    'components' => [
        'request' => [
            'enableCsrfCookie' => false,
            'enableCsrfValidation' => false,
            'cookieValidationKey' => getenv('COOKIE_VALIDATION_KEY'),
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => ['format' => Response::FORMAT_JSON],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
        ],
    ],
]);
