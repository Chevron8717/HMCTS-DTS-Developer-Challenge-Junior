import { MantineProvider } from "@mantine/core";
import { expect, test } from "vitest";
import { render } from "vitest-browser-react";
import { CreateTaskForm } from "../src/components/CreateTaskForm";
import { Task } from "../src/api/models/Task";

test('renders CreateTaskForm component', async () => {
    const { getByLabelText, getByRole, getByText } = await render(
        <MantineProvider>
            <CreateTaskForm onSubmit={() => {}} />
        </MantineProvider>
    );

    await expect.element(getByLabelText('Title')).toBeInTheDocument();
    await expect.element(getByLabelText('Due Date')).toBeInTheDocument();
    await expect.element(getByRole('button', { name: 'Create Task' })).toBeInTheDocument();

    await expect.element(getByText('+ Add Description')).toBeInTheDocument();
});

test('submits form', async () => {
    let submittedData: Task | null = null;

    const { getByLabelText, getByRole } = await render(
        <MantineProvider>
            <CreateTaskForm
                onSubmit={(data) => {
                    submittedData = data;
                }}
            />
        </MantineProvider>
    );

    const titleInput = getByLabelText('Title');
    const submitButton = getByRole('button', { name: 'Create Task' });

    await titleInput.fill('New Task');
    await submitButton.click();

    expect(submittedData).toEqual({
        title: 'New Task',
        description: '',
        due_at: expect.any(String),
        status: 'pending',
    });
});
