import { expect, test } from 'vitest'
import { render } from 'vitest-browser-react'
import { TaskList } from '../src/components/TaskList'
import { Task } from '../src/api/models/Task'
import { MantineProvider } from '@mantine/core'

test('renders TaskList component without tasks', async () => {
  const { getByText } = await render(<TaskList tasks={[]} />)

  await expect.element(getByText('No tasks available.')).toBeInTheDocument()
})

test('renders TaskList component with tasks', async () => {
  const tasks: Task[] = [
    {
        id: 1,
        title: 'Task One',
        description: 'First task description',
        status: 'pending',
        due_at: '2024-12-31T23:59:59Z',
        created_at: 1765111683,
        updated_at: 1765198083,
    },
    {
        id: 2,
        title: 'Task Two',
        description: null,
        status: 'completed',
        due_at: '2024-11-30T23:59:59Z',
        created_at: 1765025283,
        updated_at: 1765111683,
    },
  ];

  const { getByText } = await render(
    <MantineProvider>
      <TaskList tasks={tasks} />
    </MantineProvider>
  )

  await expect.element(getByText('Task One')).toBeInTheDocument()
  await expect.element(getByText('Task Two')).toBeInTheDocument()
});
