/**
 * Component for creating a new task.
 */

import { useState } from "react";
import { useForm } from "@mantine/form";
import { Box, Button, Select, Textarea, TextInput, type SelectProps } from "@mantine/core";
import { DateTimePicker } from "@mantine/dates";
import { StatusBadge } from "./StatusBadge";
import type { Task } from "../api/models/Task";

/**
 * Props for the CreateTaskForm component.
 */
interface CreateTaskFormProps {
    /**
     * Callback function to handle form submission.
     *
     * @param task The task to be created.
     */
    onSubmit: (task: Task) => void;
}

/**
 * CreateTaskForm component.
 *
 * @param param0 Props for the CreateTaskForm component.
 * @returns The CreateTaskForm component.
 */
export function CreateTaskForm({ onSubmit }: CreateTaskFormProps) {
    const [showDescription, setShowDescription] = useState(false);

    const form = useForm({
        mode: 'controlled',
        initialValues: {
            title: '',
            description: '',
            status: 'pending' as 'pending' | 'in_progress' | 'completed',
            dueAt: new Date().toISOString().slice(0, 19).replace('T', ' '),
        },
        validate: {
            title: (value) => (value.length < 1 ? 'Title is required' : null),
            status: (value) => (['pending', 'in_progress', 'completed'].includes(value) ? null : 'Invalid status'),
        },
    });

    const renderStatusOption: SelectProps['renderOption'] = ({ option }) => (
        <StatusBadge status={option.value as Task['status']} />
    );

    /**
     * Handle form submission.
     *
     * @param values Form values.
     */
    const handleSubmit = form.onSubmit(async (values) => {
        try {
            const newTask: Task = {
                title: values.title,
                description: values.description,
                status: values.status,
                due_at: values.dueAt.slice(0, 19).replace('T', ' '),
            };

            await onSubmit(newTask);

            form.reset();
        } catch (error) {
            console.error("Error creating task:", error);
        }
    });

    return (
        <form onSubmit={handleSubmit}>
            <TextInput
                label="Title"
                {...form.getInputProps('title')}
                required
            />
            <Button
                variant="subtle"
                type="button"
                color='gray'
                size='xs'
                radius='xl'
                onClick={() => {
                    const newShowState = !showDescription;
                    setShowDescription(newShowState);
                    if (!newShowState) {
                        form.setFieldValue('description', '');
                    }
                }}
            >
                {showDescription ? '- Remove Description' : '+ Add Description'}
            </Button>
            {showDescription && (
                <Textarea
                    label="Description"
                    {...form.getInputProps('description')}
                />
            )}
            <Select
                label="Status"
                data={[
                    { value: 'pending', label: 'Pending' },
                    { value: 'in_progress', label: 'In Progress' },
                    { value: 'completed', label: 'Completed' },
                ]}
                {...form.getInputProps('status')}
                renderOption={renderStatusOption}
            />
            <DateTimePicker
                label="Due Date"
                {...form.getInputProps('dueAt')}
            />
            <Box mt="md">
                <Button type="submit">Create Task</Button>
            </Box>
        </form>
    );
};
