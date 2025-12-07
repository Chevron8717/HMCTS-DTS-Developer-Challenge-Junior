<?php

declare(strict_types=1);

namespace app\rest;

use Override;
use yii\filters\Cors;
use yii\rest\Controller as RestController;
use yii\rest\OptionsAction;

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

        $behaviors['cors'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost:5173'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
            ],
        ];

        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function actions()
    {
        return [
            'options' => [
                'class' => OptionsAction::class,
            ],
        ];
    }
}
