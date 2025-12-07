const API_BASE_URL = 'http://localhost:8000';

/**
 * Makes a fetch request to the specified API endpoint.
 *
 * @param endpoint The API endpoint to fetch, relative to the base URL.
 * @param options Fetch options such as method, headers, body, etc.
 * @returns The parsed JSON response from the API.
 */
export async function apiFetch(endpoint: string, options: RequestInit = {}) {
    const response = await fetch(`${API_BASE_URL}/${endpoint}`, {
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        ...options,
    });

    if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'API request failed');
    }

    return await response.json();
}
