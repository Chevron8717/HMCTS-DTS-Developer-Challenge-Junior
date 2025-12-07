<?php

declare(strict_types=1);

namespace app\models;

use Override;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Model class for table `{{%tasks}}`.
 *
 * A task represents a unit of work to be completed.
 *
 * @property int $id Primary key.
 * @property string $title Title of the task.
 * @property string|null $description Detailed description of the task.
 * @property string $status Current status of the task.
 * @property string $due_at Due date and time for the task.
 * @property int $created_at Timestamp when the task was created.
 * @property int $updated_at Timestamp when the task was last updated.
 */
final class Task extends ActiveRecord
{
    /**
     * The status indicating the task is pending.
     */
    public const string STATUS_PENDING = 'pending';

    /**
     * The status indicating the task is in progress.
     */
    public const string STATUS_IN_PROGRESS = 'in_progress';

    /**
     * The status indicating the task is completed.
     */
    public const string STATUS_COMPLETED = 'completed';

    /**
     * The list of valid task statuses.
     */
    public const array STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_IN_PROGRESS,
        self::STATUS_COMPLETED,
    ];

    /**
     * {@inheritdoc}
     */
    #[Override]
    public static function tableName(): string
    {
        return '{{%tasks}}';
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function behaviors(): array
    {
        return [
            'timestamp' => ['class' => TimestampBehavior::class],
        ];
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function rules(): array
    {
        return [
            'trim' => [['title', 'description'], 'trim'],
            'castEmptyStringToNull' => [
                ['title', 'description'],
                'filter',
                'filter' => fn (string $value) => $value === '' ? null : $value,
            ],
            'required' => [['title', 'status', 'due_at'], 'required'],
            'shortText' => [['title'], 'string', 'max' => 255],
            'longText' => [['description'], 'string', 'max' => 65535],
            'datetime' => [['due_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            'statusEnum' => [['status'], 'in', 'range' => self::STATUSES],
        ];
    }
}
