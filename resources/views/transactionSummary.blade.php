<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Transaction Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Same styling as before */
    </style>
    <script src="js/TransactionAPIHandler.js"></script> <!-- Ensure this is the correct path -->
</head>
<body>
    <!-- Trigger button for the modal -->
    <button id="openModalBtn">Enter Loyalty ID</button>

    <!-- Modal -->
    <div id="loyaltyModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeModalBtn">&times;</span>
            <h2>Loyalty Transaction Summary</h2>

            <!-- Form inside modal -->
            <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>

            <form id="loyaltyForm">
                <label for="loyaltyId">Loyalty ID:</label>
                <input type="text" id="loyaltyId" name="loyaltyCardUID" placeholder="Enter your Loyalty ID" required>
                <button type="submit">Submit</button>
            </form>

            <div id="transactionSummary"></div>
        </div>
    </div>

    <script>
    const modal = document.getElementById('loyaltyModal');
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const loyaltyForm = document.getElementById('loyaltyForm');
    const errorMessage = document.getElementById('errorMessage');
    const transactionSummary = document.getElementById('transactionSummary');

    // Open the modal when the button is clicked
    openModalBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    // Close the modal when the close button is clicked
    closeModalBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Close modal when clicking outside the modal
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Loyalty form submission
    loyaltyForm.addEventListener('submit', async (event) => {
        event.preventDefault(); // Prevent default form submission

        const loyaltyCardId = document.getElementById('loyaltyId').value;

        if (!loyaltyCardId) {
            displayError('Please enter a Loyalty Card ID.');
            return;
        }

        try {
            // Call the apiHandler function from apiHandler.js
            const transactionsData = await TransactionAPIHandler('fetchTransactionsByLoyaltyCard', loyaltyCardId);

            console.log('Fetched Transactions Data:', transactionsData);

            // Render the transactions table
            renderLoyaltyCard(transactionsData);
        } catch (error) {
            displayError(error || 'An error occurred while fetching the data.');
        }
    });

    // Function to render the Loyalty Card data
    function renderLoyaltyCard(loyaltyCard) {
        if (!loyaltyCard || !loyaltyCard.transactions || loyaltyCard.transactions.length === 0) {
            transactionSummary.innerHTML = '<p>No transactions found for the provided Loyalty ID.</p>';
            return;
        }

        let transactionsHtml = `
            <h3>Transaction Summary for Loyalty Card</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Total Points Used</th>
                        <th>Points Earned</th>
                        <th>Transaction Date</th>
                    </tr>
                </thead>
                <tbody>
        `;

        // Loop through the transactions array
        loyaltyCard.transactions.forEach(transaction => {
            transactionsHtml += `
                <tr>
                    <td>${transaction.TransactionUniqueIdentifier}</td>
                    <td>${transaction.OrderUniqueIdentifier}</td>
                    <td>${transaction.UserUniqueIdentifier}</td>
                    <td>${transaction.TotalPointsUsed}</td>
                    <td>${transaction.PointsEarned}</td>
                    <td>${transaction.TransactionDate}</td>
                </tr>
            `;
        });

        transactionsHtml += `</tbody></table>`;
        transactionSummary.innerHTML = transactionsHtml; // Update the DOM
    }

    function displayError(message) {
        errorMessage.style.display = 'block';
        errorMessage.textContent = message;
    }
    </script>
</body>
</html>
