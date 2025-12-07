import { useEffect, useState } from "react";
import type { Task } from "../api/models/Task";
import { apiFetch } from "../api/client";

/**
 * Custom hook to manage tasks fetching and state.
 *
 * @returns An object containing tasks, loading state, error state, a fetchTasks
 * function for refetching tasks, and a createTask function for adding new tasks.
 */
export function useTasks() {
    const [tasks, setTasks] = useState<Task[]>([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

    /**
     * Fetch tasks from the API.
     */
    async function fetchTasks() {
        setLoading(true);
        setError(null);
        try {
            const data: Task[] = await apiFetch('tasks');
            setTasks(data);
        } catch (err) {
            setError(err instanceof Error ? err.message : 'Unknown error');
        } finally {
            setLoading(false);
        }
    }

    /**
     * Create a new task via the API.
     *
     * @param Task The task to create.
     */
    async function createTask(Task: Task) {
        setLoading(true);
        setError(null);
        try {
            await apiFetch('tasks', {
                method: 'POST',
                body: JSON.stringify(Task),
            });
            await fetchTasks();
        } catch (err) {
            setError(err instanceof Error ? err.message : 'Unknown error');
        } finally {
            setLoading(false);
        }
    }

    /**
     * Update an existing task via the API.
     *
     * @param id The ID of the task to update.
     * @param updates The updates to apply to the task.
     */
    async function updateTask(id: number, updates: Partial<Task>) {
        setLoading(true);
        setError(null);
        try {
            await apiFetch(`tasks/${id}`, {
                method: 'PUT',
                body: JSON.stringify(updates),
            });
            await fetchTasks();
        } catch (err) {
            setError(err instanceof Error ? err.message : 'Unknown error');
        } finally {
            setLoading(false);
        }
    }

    useEffect(() => {
        fetchTasks();
    }, []);

    return { tasks, loading, error, fetchTasks, createTask, updateTask };
}
