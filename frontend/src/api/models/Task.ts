/**
 * Represents a Task model in the application.
 */
export interface Task {
    /**
     * Unique identifier for the task.
     */
    id?: number;
    /**
     * Short title of the task.
     */
    title: string;
    /**
     * Longer description of the task.
     */
    description: string | null;
    /**
     * Current status of the task.
     */
    status: 'pending' | 'in_progress' | 'completed';
    /**
     * Due date/time of the task.
     */
    due_at: string;
    /**
     * Creation timestamp of the task.
     */
    created_at?: number;
    /**
     * Last update timestamp of the task.
     */
    updated_at?: number;
};

/**
 * Mapping of task statuses to their corresponding colors.
 */
export const statusColors: Record<string, string> = {
    pending: 'yellow',
    in_progress: 'blue',
    completed: 'green',
};
