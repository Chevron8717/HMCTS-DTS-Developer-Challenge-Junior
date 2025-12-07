<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use app\models\Task;
use app\services\TaskService;
use Codeception\Attribute\DataProvider;
use Codeception\Example;
use Tests\Support\Data\Fixtures\TaskFixture;
use Tests\Support\UnitTester;

/**
 * Unit tests for the TaskService class.
 *
 * @see \app\services\TaskService
 */
final class TaskServiceCest
{
    /**
     * Data provider for task actions (create and update).
     *
     * @return array<string, list{
     *   0: 'create'|'update', // The action type.
     *   1: callable(): Task, // A callable that returns a Task model
     * }> The task actions.
     */
    protected function taskActionProvider(): array
    {
        return [
            'create' => [
                'action' => 'create',
                'taskFactory' => fn (): Task => new Task(),
            ],
            'update' => [
                'action' => 'update',
                'taskFactory' => fn (): ?Task => Task::find()->one(),
            ],
        ];
    }

    /**
     * Tests that `save()` correctly saves a Task model with valid data.
     *
     * @param UnitTester $I The unit tester instance.
     * @param Example $example The example data from the data provider.
     *
     * @see \app\services\TaskService::save()
     */
    #[DataProvider('taskActionProvider')]
    public function testSaveValidTask(UnitTester $I, Example $example): void
    {
        $I->haveFixtures([
            TaskFixture::class,
        ]);

        /** @var 'create'|'update' */
        $action = $example['action'];
        /** @var callable(): ?Task */
        $taskFactory = $example['taskFactory'];

        $task = ($taskFactory)();
        $I->assertInstanceOf(Task::class, $task);

        $task->title = 'Test Task';
        $task->description = 'This is a test task.';
        $task->status = Task::STATUS_PENDING;
        $task->due_at = '2024-01-15 12:00:00';

        $taskService = new TaskService();
        $result = $taskService->save($task);

        $I->assertTrue($result);

        // Verify that the task was saved correctly.
        $savedTask = Task::findOne(['title' => 'Test Task']);
        $I->assertNotNull($savedTask);

        $I->assertSame('Test Task', $savedTask->title);
        $I->assertSame('This is a test task.', $savedTask->description);
        $I->assertSame(Task::STATUS_PENDING, $savedTask->status);
        $I->assertSame('2024-01-15 12:00:00', $savedTask->due_at);
    }
}
