<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Update Loyalty Card Points</title>
    
    <!-- Include the JS file from public/js -->
    <script src="js/apiHandler.js"></script>
</head>
<body>
    <h1>Update Loyalty Card Points</h1>

    <label for="loyalty-card-id">Enter Loyalty Card ID:</label>
    <input type="number" id="loyalty-card-id" placeholder="Enter Loyalty Card ID" required>

    <label for="loyalty-card-points">Enter Points:</label>
    <input type="number" id="loyalty-card-points" placeholder="Enter Points" required>

    <button onclick="updateLoyaltyCard()">Update Points</button>

    <div id="loyalty-card-details">Loyalty card details will appear here after update.</div>
    <div id="error-message"></div>

    <script>
        async function updateLoyaltyCard() {
            const loyaltyCardId = document.getElementById('loyalty-card-id').value;
            const points = document.getElementById('loyalty-card-points').value;

            try {
                const updatedLoyaltyCard = await apiHandler('updateLoyaltyCard', loyaltyCardId, { Points: points });
                renderUpdatedLoyaltyCard(updatedLoyaltyCard);
            } catch (error) {
                displayError(error);
            }
        }

        // Function to render the updated loyalty card data
        function renderUpdatedLoyaltyCard(loyaltyCard) {
            const loyaltyCardDetails = document.getElementById('loyalty-card-details');
            loyaltyCardDetails.innerHTML = ''; // Clear previous content

            if (!loyaltyCard || !loyaltyCard.LoyaltyCardID) {
                loyaltyCardDetails.innerHTML = '<p>Failed to update loyalty card. Try again later.</p>';
                return;
            }

            loyaltyCardDetails.innerHTML = `
                <strong>Loyalty Card ID:</strong> ${loyaltyCard.LoyaltyCardID} <br>
                <strong>Updated Points:</strong> ${loyaltyCard.Points}
            `;
        }

        // Function to handle displaying error messages
        function displayError(message) {
            const errorDiv = document.getElementById('error-message');
            errorDiv.innerHTML = `<p>Error: ${message}</p>`;
        }
    </script>
</body>
</html>
