import { Box, Card, Group, Stack, Text } from "@mantine/core";
import type { Task } from "../api/models/Task";
import { StatusBadge } from "./StatusBadge";
import { IconClock } from "@tabler/icons-react";

/**
 * Props for the TaskList component.
 */
interface TaskListProps {
    tasks: Task[];
};

export function TaskList({ tasks }: TaskListProps) {
    if (tasks.length === 0) {
        return <p>No tasks available.</p>;
    }

    function isOverdue(dueAt: string): boolean {
        const now = new Date();
        const due = new Date(dueAt);
        return due < now;
    }

    return (
        <Stack gap="md">
            {tasks.map((task) => (
                <Card key={task.id} p="md" shadow="sm" withBorder bg="gray.0">
                    <Group justify="space-between" align="center" mb="xs">
                        <Text fw={600}>{task.title}</Text>
                        <StatusBadge status={task.status} />
                    </Group>
                    {task.description && (
                        <Box mt="sm">
                            <Text size="sm">
                                {task.description}
                            </Text>
                        </Box>
                    )}
                    <Text size="xs" mt="sm" ta="right"
                        fw={isOverdue(task.due_at) ? 700 : 300}
                        c={isOverdue(task.due_at) ? "red" : "dimmed"}
                    >
                        <Group justify="flex-end" align="center" gap={5}>
                            <IconClock size={12} />
                            Due: {new Date(task.due_at).toLocaleString()}
                        </Group>
                    </Text>
                </Card>
            ))}
        </Stack>
    );
};
