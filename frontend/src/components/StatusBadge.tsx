import { Badge } from "@mantine/core";

/**
 * Props for the StatusBadge component.
 *
 * @param param0 Props containing the status string.
 * @returns A Badge component representing the status.
 */
export function StatusBadge({ status }: { status: 'pending' | 'in_progress' | 'completed' }) {
    const statusColors: Record<string, string> = {
        pending: 'yellow',
        in_progress: 'blue',
        completed: 'green',
    };

    const statusLabels: Record<string, string> = {
        pending: 'Pending',
        in_progress: 'In Progress',
        completed: 'Completed',
    };

    return (
        <Badge color={statusColors[status]} variant="light">
            {statusLabels[status]}
        </Badge>
    );
}
