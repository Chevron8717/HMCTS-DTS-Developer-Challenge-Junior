<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 */
final class m251207_110538_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    #[Override]
    public function safeUp(): void
    {
        $this->execute("CREATE TYPE task_status_enum AS ENUM ('pending', 'in_progress', 'completed')");

        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'status' => 'task_status_enum NOT NULL',
            'due_at' => $this->dateTime()->notNull(),
            'created_at' => $this->bigInteger()->notNull(),
            'updated_at' => $this->bigInteger()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function safeDown(): void
    {
        $this->dropTable('{{%tasks}}');
        $this->execute('DROP TYPE task_status_enum');
    }
}
