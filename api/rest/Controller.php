<?php

declare(strict_types=1);

namespace app\rest;

use Override;
use yii\rest\Controller as RestController;

/**
 * Base REST controller class for the application.
 */
abstract class Controller extends RestController
{
    /**
     * {@inheritdoc}
     */
    #[Override]
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        unset(
            $behaviors['authenticator'], // Not used in this application.
            $behaviors['rateLimiter'], // Cannot be used without user identity.
        );

        return $behaviors;
    }
}
