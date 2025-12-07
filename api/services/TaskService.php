<?php

declare(strict_types=1);

namespace app\services;

use app\models\Task;
use Yii;
use yii\web\ServerErrorHttpException;

/**
 * Service class for handling business logic related to Task resources.
 *
 * @see \app\models\Task
 */
final class TaskService
{
    /**
     * Saves the given Task model to the database.
     *
     * @param Task $task The Task model to save.
     *
     * @return bool True if the Task was saved successfully, false if validation
     * errors occurred.
     *
     * @throws ServerErrorHttpException If the Task could not be saved due to an
     * internal server error.
     */
    public function save(Task $task): bool
    {
        if (!$task->save()) {
            if ($task->hasErrors()) {
                return false;
            }

            $action = $task->isNewRecord ? 'create' : 'update';

            Yii::debug(
                "Failed to {$action} Task. This is most likely due to ActiveRecord
                    hooks preventing save, as no validation errors were found and no
                    database exceptions were thrown.",
                __METHOD__,
            );

            throw new ServerErrorHttpException(
                "Failed to {$action} Task due to an internal server error.",
            );
        }

        return true;
    }
}
