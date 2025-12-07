<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Task;
use app\rest\Controller;
use app\services\TaskService;
use Override;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

/**
 * Handles requests related to the Task resource.
 *
 * Note: Yii also provides a built-in REST controller (`ActiveController`) that
 * comes with standard CRUD actions. This custom controller is created for
 * demonstration purposes, and includes improved type hinting and error handling
 * than Yii's default implementation.
 *
 * @see \app\models\Task
 */
final class TaskController extends Controller
{
    /**
     * Lists all Task resources.
     *
     * @return ActiveDataProvider The data provider containing Task resources.
     */
    public function actionIndex(): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find(),
        ]);

        return $dataProvider;
    }

    /**
     * Returns a single Task resource by its ID.
     *
     * @param int $id The ID of the Task to retrieve.
     *
     * @return Task The Task resource.
     *
     * @throws NotFoundHttpException If the Task with the specified ID does
     * not exist.
     */
    public function actionView(int $id): Task
    {
        $task = Task::findOne(['id' => $id]);

        if ($task === null) {
            throw new NotFoundHttpException("Task with ID '{$id}' does not exist.");
        }

        return $task;
    }

    /**
     * Creates a new Task resource using data provided in the request body.
     *
     * @param TaskService $service The service responsible for saving the Task.
     *
     * @return Task The newly created Task resource on success, or the Task
     * model with validation errors on validation failure.
     *
     * @throws ServerErrorHttpException If the Task could not be created due to
     * a server error.
     */
    public function actionCreate(TaskService $service): Task
    {
        $task = new Task();
        $task->load((array) $this->request->getBodyParams(), '');

        if (!$service->save($task)) {
            // Yii will serialise the model with validation errors and set the
            // response status code to 422 (Unprocessable Entity).
            return $task;
        }

        $this->response->setStatusCode(201); // Created
        return $task;
    }

    /**
     * Updates an existing Task resource identified by its ID using data
     * provided in the request body.
     *
     * @param int $id The ID of the Task to update.
     * @param TaskService $service The service responsible for saving the Task.
     *
     * @return Task The updated Task resource, or the Task model with validation
     * errors on validation failure.
     *
     * @throws NotFoundHttpException If the Task with the specified ID does
     * not exist.
     * @throws ServerErrorHttpException If the Task could not be updated due to
     * a server error.
     */
    public function actionUpdate(int $id, TaskService $service): Task
    {
        $task = Task::findOne(['id' => $id]);

        if ($task === null) {
            throw new NotFoundHttpException("Task with ID '{$id}' does not exist.");
        }

        $task->load((array) $this->request->getBodyParams(), '');

        if (!$service->save($task)) {
            // Yii will serialise the model with validation errors and set the
            // response status code to 422 (Unprocessable Entity).
            return $task;
        }

        return $task;
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    protected function verbs(): array
    {
        return [
            'index' => ['GET', 'OPTIONS'],
            'view' => ['GET', 'OPTIONS'],
            'create' => ['POST', 'OPTIONS'],
            'update' => ['PUT', 'OPTIONS'],
        ];
    }
}
