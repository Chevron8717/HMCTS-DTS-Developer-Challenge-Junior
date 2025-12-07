import { MantineProvider } from "@mantine/core";
import { expect, test } from "vitest";
import { render } from "vitest-browser-react";
import { StatusBadge } from "../src/components/StatusBadge";

test('renders StatusBadge component', async () => {
    const { getByText } = await render(
        <MantineProvider>
            <div>
                <StatusBadge status="pending" />
                <StatusBadge status="in_progress" />
                <StatusBadge status="completed" />
            </div>
        </MantineProvider>
    );

    await expect.element(getByText('Pending')).toBeInTheDocument();
    await expect.element(getByText('In Progress')).toBeInTheDocument();
    await expect.element(getByText('Completed')).toBeInTheDocument();
});
