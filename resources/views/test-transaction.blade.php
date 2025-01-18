<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Transaction</title>
    <script>
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

        // Function to trigger addTransaction
        function submitTransactionForm() {
            const orderId = document.getElementById('order_id').value;
            const userId = document.getElementById('user_id').value;
            const loyaltyCardId = document.getElementById('loyalty_card').value;
            const totalPointsUsed = document.getElementById('total_points_used').value;
            const pointsEarned = document.getElementById('points_earned').value;

            // Call the addTransaction function with form values
            addTransaction(orderId, userId, loyaltyCardId, totalPointsUsed, pointsEarned);
        }
    </script>
</head>
<body>
    <h1>Test Transaction</h1>

    <form id="transactionForm" onsubmit="event.preventDefault(); submitTransactionForm();">
        <div>
            <label for="order_id">Order ID:</label>
            <input type="text" id="order_id" name="order_id" required>
        </div>
        <div>
            <label for="user_id">User ID:</label>
            <input type="text" id="user_id" name="user_id" required>
        </div>
        <div>
            <label for="loyalty_card">Loyalty Card ID:</label>
            <input type="text" id="loyalty_card" name="loyalty_card" required>
        </div>
        <div>
            <label for="total_points_used">Total Points Used:</label>
            <input type="number" id="total_points_used" name="total_points_used" required>
        </div>
        <div>
            <label for="points_earned">Points Earned:</label>
            <input type="number" id="points_earned" name="points_earned" required>
        </div>

        <button type="submit">Submit Transaction</button>
    </form>

    <script>
        // Optional: You can add additional validation or logic to handle responses
    </script>
</body>
</html>
