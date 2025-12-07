import './App.css'
import '@mantine/core/styles.css';
import '@mantine/dates/styles.css';

import { AppShell, Box, Container, Flex, Grid, MantineProvider } from '@mantine/core';
import { CreateTaskForm } from './components/CreateTaskForm';
import { TaskList } from './components/TaskList';
import { useTasks } from './hooks/useTasks';

/**
 * Main application component.
 *
 * @returns The main application component.
 */
function App() {
  const { tasks, loading, error, createTask } = useTasks();

  if (loading) return <div>Loading...</div>;
  if (error) return <div>Error: {error}</div>;

  return (
    <MantineProvider>
      <AppShell
        padding="md"
        header={{ height: 50 }}
      >
        <AppShell.Header>
          <Box p="xs" fw={700} fz="lg">
            <div>HMCTS DTS - Tasks</div>
          </Box>
        </AppShell.Header>
        <AppShell.Main>
          <Container size="lg">
            <Grid mb="md">
              <Grid.Col span={{ base: 12, sm: 5 }}>
                <Box mb="md" bg="gray.0" p="md">
                  <CreateTaskForm onSubmit={createTask} />
                </Box>
              </Grid.Col>
              <Grid.Col span={{ base: 12, sm: 6 }}>
                <TaskList tasks={tasks} />
              </Grid.Col>
            </Grid>
          </Container>
        </AppShell.Main>
      </AppShell>
    </MantineProvider>
  );
}

export default App
