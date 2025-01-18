<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Transaction</title>
    <!-- Link to the External JS file -->
    <script src="js/transactions.js"></script>
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
        // Function to handle form submission and call addTransaction
        function submitTransactionForm() {
            const orderId = document.getElementById('order_id').value;
            const userId = document.getElementById('user_id').value;
            const loyaltyCardId = document.getElementById('loyalty_card').value;
            const totalPointsUsed = document.getElementById('total_points_used').value;
            const pointsEarned = document.getElementById('points_earned').value;

            // Call the addTransaction function from the external JS file
            addTransaction(orderId, userId, loyaltyCardId, totalPointsUsed, pointsEarned);
        }
    </script>
</body>
</html>
