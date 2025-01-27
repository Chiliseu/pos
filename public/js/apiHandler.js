let token = null; // Store the Bearer token

async function fetchToken(forceRefresh = false) {
    if (!token || forceRefresh) {
        try {
            const response = await fetch(`${baseUrl}/generate-token`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
            });

            if (!response.ok) {
                throw new Error(`Failed to generate token. Status: ${response.status}`);
            }

            const data = await response.json();
            if (!data.token) {
                throw new Error('Token not found in response');
            }

            token = data.token; // Store the new token globally
        } catch (error) {
            console.error('Error generating token:', error);
            throw new Error('Unable to generate token');
        }
    }
}

async function apiHandler(action, id, data = null) {
    const baseUrl = 'https://loyalty-production.up.railway.app/api';
    let url = '';
    let method = '';
    let body = null;
    let headers = {
        'Content-Type': 'application/json',
    };

    // Determine the endpoint and HTTP method based on action
    switch (action) {
        case 'fetchLoyaltyCard':
            url = `${baseUrl}/loyalty-cards/${id}`;
            method = 'GET';
            break;

        case 'updateLoyaltyCard':
            url = `${baseUrl}/loyalty-cards/${id}`;
            method = 'PUT';
            body = JSON.stringify(data);
            break;
        
        default:
            console.error('Invalid action:', action);
            return Promise.reject('Invalid action');
    }

    try {
        // Ensure we have a valid token before making the request
        await fetchToken();

        headers['Authorization'] = `Bearer ${token}`;

        const options = {
            method,
            headers,
        };

        // Include the body for PUT requests
        if (body) {
            options.body = body;
        }

        const response = await fetch(url, options);

        // If the token is expired (401), retry with a new token
        if (response.status === 401 || response.status === 403) {
            console.warn('Token expired. Fetching new token...');
            await fetchToken(true); // Force token refresh
            headers['Authorization'] = `Bearer ${token}`; // Update the header with the new token

            // Retry the request with the new token
            const retryResponse = await fetch(url, options);
            return await retryResponse.json();
        }

        // Handle other response statuses
        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.statusText || 'Unknown error'}`);
        }

        const responseData = await response.json();
        return responseData;

    } catch (error) {
        console.error('API Error:', error.message);
        return Promise.reject(error.message);
    }
}
