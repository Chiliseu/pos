async function addTransaction(orderId, userId, loyaltyCardId, totalPointsUsed, pointsEarned) {
    let loyaltyCardID;

    try {
        const baseUrl = 'https://loyalty-production.up.railway.app/api';
        const tokenUrl = `${baseUrl}/generate-token`;
        const loyaltyCardUrl = `${baseUrl}/loyalty-cards/${loyaltyCardId}`;

        // Step 1: Generate token
        const tokenResponse = await fetch(tokenUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!tokenResponse.ok) {
            throw new Error('Unable to generate token from loyalty system');
        }

        const tokenData = await tokenResponse.json();
        const token = tokenData.token;

        if (!token) {
            throw new Error('Token not found in loyalty system response');
        }

        // Step 2: Fetch the LoyaltyCard data using the token
        const loyaltyCardResponse = await fetch(loyaltyCardUrl, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
        });

        if (loyaltyCardResponse.status === 404) {
            throw new Error('Loyalty Card not found');
        }

        if (!loyaltyCardResponse.ok) {
            throw new Error('Failed to fetch Loyalty Card from loyalty system');
        }

        const loyaltyCard = await loyaltyCardResponse.json();

        // Step 3: Validate LoyaltyCard data
        if (!loyaltyCard.LoyaltyCardID) {
            throw new Error('Invalid Loyalty Card data received from API');
        }

        loyaltyCardID = loyaltyCard.LoyaltyCardID;
        console.log('Loyalty Card ID:', loyaltyCardID);

        // Step 4: Format the current date as YYYY-MM-DD
        const currentDate = new Date();
        const formattedDate = currentDate.toISOString().split('T')[0];

        // Step 5: Generate the Bearer Token for POS system
        const posTokenResponse = await fetch('https://pos-production-c2c1.up.railway.app/api/generate-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        });

        if (!posTokenResponse.ok) {
            const errorData = await posTokenResponse.json();
            throw new Error(`POS token generation failed: ${errorData.message || 'Unknown error'}`);
        }

        const posTokenData = await posTokenResponse.json();
        const bearerToken = posTokenData.token;

        // Step 6: Add the Transaction using the Bearer Token
        const transactionData = {
            OrderID: orderId,
            UserID: userId,
            LoyaltyCardID: loyaltyCardID,
            TotalPointsUsed: totalPointsUsed,
            PointsEarned: pointsEarned,
            TransactionDate: formattedDate,
        };

        const transactionResponse = await fetch('https://pos-production-c2c1.up.railway.app/api/transactions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${bearerToken}`,
            },
            body: JSON.stringify(transactionData),
        });

        if (!transactionResponse.ok) {
            const errorData = await transactionResponse.json();
            throw new Error(`Transaction creation failed: ${errorData.message || 'Unknown error'}`);
        }

        const transactionResult = await transactionResponse.json();
        console.log('Transaction created:', transactionResult);

    } catch (error) {
        console.error('Error:', error.message);
    }
}


