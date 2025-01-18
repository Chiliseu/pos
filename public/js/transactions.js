async function addTransaction(orderId, userId, loyaltyCardId, totalPointsUsed, pointsEarned) {
    try {
        // Step 1: Format the current date as YYYY-MM-DD
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Month is 0-based
        const day = String(currentDate.getDate()).padStart(2, '0');
        const formattedDate = `${year}-${month}-${day}`;

        // Step 2: Generate the Bearer Token
        const tokenResponse = await fetch('https://pos-production-c2c1.up.railway.app/api/generate-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        });

        if (!tokenResponse.ok) {
            const errorData = await tokenResponse.json();
            throw new Error(`Token generation failed: ${errorData.message || 'Unknown error'}`);
        }

        const tokenData = await tokenResponse.json();
        const bearerToken = tokenData.token;

        // Step 3: Add the Transaction using the Bearer Token
        const transactionData = {
            OrderID: orderId,
            UserID: userId,
            LoyaltyCardID: loyaltyCardId,
            TotalPointsUsed: totalPointsUsed,
            PointsEarned: pointsEarned,
            TransactionDate: formattedDate, // Use the formatted current date
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

        // Handle success (e.g., show a success message or update the UI)
    } catch (error) {
        console.error('Error:', error);
        // Handle errors (e.g., show error messages)
    }
}

function submitTransactionForm() {
    const orderId = document.getElementById('order_id').value;
    const userId = document.getElementById('user_id').value;
    const loyaltyCardId = document.getElementById('loyalty_card').value;
    const totalPointsUsed = document.getElementById('total_points_used').value;
    const pointsEarned = document.getElementById('points_earned').value;

    // Call the addTransaction function with form values
    addTransaction(orderId, userId, loyaltyCardId, totalPointsUsed, pointsEarned);
}