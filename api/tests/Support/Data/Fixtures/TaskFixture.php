<?php

declare(strict_types=1);

namespace Tests\Support\Data\Fixtures;

use yii\test\ActiveFixture;

/**
 * Fixture for the `{{%tasks}}` table.
 *
 * @see data/task.php For the actual fixture data.
 */
final class TaskFixture extends ActiveFixture
{
    /**
     * {@inheritdoc}
     */
    public $tableName = '{{%tasks}}';

    /**
     * {@inheritdoc}
     */
    public $depends = [];
}
