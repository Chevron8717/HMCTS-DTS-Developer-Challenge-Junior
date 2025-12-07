<?php

/**
 * API entry script for web requests.
 */

declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
