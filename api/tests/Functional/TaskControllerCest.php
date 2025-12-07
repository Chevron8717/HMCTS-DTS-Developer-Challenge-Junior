<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers;

use app\models\Task;
use Tests\Support\Data\Fixtures\TaskFixture;
use Tests\Support\FunctionalTester;

/**
 * Functional tests for TaskController.
 *
 * @see \app\controllers\TaskController
 */
final class TaskControllerCest
{
    /**
     * Tests that the index action returns a list of tasks.
     *
     * @param FunctionalTester $I The functional tester instance.
     *
     * @see \app\controllers\TaskController::actionIndex()
     */
    public function testIndexReturnsListOfTasks(FunctionalTester $I): void
    {
        $I->haveFixtures([TaskFixture::class]);

        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGet('/tasks');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'id' => 1,
                'title' => 'Sample Task 1',
                'description' => 'This is the first sample task.',
                'status' => 'pending',
                'due_at' => '2024-01-05 12:00:00',
                'created_at' => 1765111683,
                'updated_at' => 1765111683,
            ],
            [
                'id' => 2,
                'title' => 'Sample Task 2',
                'description' => 'This is the second sample task.',
                'status' => 'completed',
                'due_at' => '2024-01-10 15:00:00',
                'created_at' => 1765198080,
                'updated_at' => 1765198080,
            ],
        ]);
    }

    /**
     * Tests that the view action returns a single task.
     *
     * @param FunctionalTester $I The functional tester instance.
     *
     * @see \app\controllers\TaskController::actionView()
     */
    public function testViewReturnsSingleTask(FunctionalTester $I): void
    {
        $I->haveFixtures([TaskFixture::class]);

        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGet('/tasks/1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'id' => 1,
            'title' => 'Sample Task 1',
            'description' => 'This is the first sample task.',
            'status' => 'pending',
            'due_at' => '2024-01-05 12:00:00',
            'created_at' => 1765111683,
            'updated_at' => 1765111683,
        ]);
    }

    /**
     * Tests that the view action returns a 404 for a non-existent task.
     *
     * @param FunctionalTester $I The functional tester instance.
     *
     * @see \app\controllers\TaskController::actionView()
     */
    public function testViewReturns404ForNonExistentTask(FunctionalTester $I): void
    {
        $I->haveFixtures([TaskFixture::class]);

        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGet('/tasks/999');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'message' => 'Task with ID \'999\' does not exist.',
        ]);
    }

    /**
     * Tests that a new task can be created successfully.
     *
     * @param FunctionalTester $I The functional tester instance.
     *
     * @see \app\controllers\TaskController::actionCreate()
     */
    public function testCreateTask(FunctionalTester $I): void
    {
        $I->haveFixtures([TaskFixture::class]);

        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/tasks', [
            'title' => 'New Task',
            'description' => 'This is a new task.',
            'status' => 'pending',
            'due_at' => '2024-02-01 10:00:00',
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'title' => 'New Task',
            'description' => 'This is a new task.',
            'status' => 'pending',
            'due_at' => '2024-02-01 10:00:00',
        ]);

        $I->seeRecord(Task::class, [
            'title' => 'New Task',
            'description' => 'This is a new task.',
            'status' => 'pending',
            'due_at' => '2024-02-01 10:00:00',
        ]);
    }

    /**
     * Tests that creating a task with invalid data returns validation errors.
     *
     * @param FunctionalTester $I The functional tester instance.
     *
     * @see \app\controllers\TaskController::actionCreate()
     */
    public function testCreateTaskValidationFailure(FunctionalTester $I): void
    {
        $I->haveFixtures([TaskFixture::class]);

        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/tasks', [
            'title' => '', // Title is required, so this should fail validation
            'description' => 'This task has no title.',
            'status' => 'pending',
            'due_at' => '2024-02-01 10:00:00',
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            0 => ['field' => 'title', 'message' => 'Title cannot be blank.'],
        ]);
    }

    /**
     * Tests that an existing task can be updated successfully.
     *
     * @param FunctionalTester $I The functional tester instance.
     *
     * @see \app\controllers\TaskController::actionUpdate()
     */
    public function testUpdateTask(FunctionalTester $I): void
    {
        $I->haveFixtures([TaskFixture::class]);

        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/tasks/1', [
            'title' => 'Updated Task Title',
            'description' => 'Updated description.',
            'status' => 'completed',
            'due_at' => '2024-01-15 09:00:00',
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'id' => 1,
            'title' => 'Updated Task Title',
            'description' => 'Updated description.',
            'status' => 'completed',
            'due_at' => '2024-01-15 09:00:00',
        ]);

        $I->seeRecord(Task::class, [
            'id' => 1,
            'title' => 'Updated Task Title',
            'description' => 'Updated description.',
            'status' => 'completed',
            'due_at' => '2024-01-15 09:00:00',
        ]);
    }

    /**
     * Tests that updating a non-existent task returns a 404 error.
     *
     * @param FunctionalTester $I The functional tester instance.
     *
     * @see \app\controllers\TaskController::actionUpdate()
     */
    public function testUpdateReturns404ForNonExistentTask(FunctionalTester $I): void
    {
        $I->haveFixtures([TaskFixture::class]);

        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/tasks/999', [
            'title' => 'Updated Task Title',
            'description' => 'Updated description.',
            'status' => 'completed',
            'due_at' => '2024-01-15 09:00:00',
        ]);
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'message' => "Task with ID '999' does not exist.",
        ]);
    }

    /**
     * Tests that updating a task with invalid data returns validation errors.
     *
     * @param FunctionalTester $I The functional tester instance.
     *
     * @see \app\controllers\TaskController::actionUpdate()
     */
    public function testUpdateTaskValidationFailure(FunctionalTester $I): void
    {
        $I->haveFixtures([TaskFixture::class]);

        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/tasks/1', [
            'title' => '', // Title is required, so this should fail validation
            'description' => 'This task has no title.',
            'status' => 'pending',
            'due_at' => '2024-01-15 09:00:00',
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            0 => ['field' => 'title', 'message' => 'Title cannot be blank.'],
        ]);
    }
}
