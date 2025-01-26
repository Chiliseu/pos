<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Transaction Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Modal styling */
        .modal {
            display: none; /* Hidden by default */
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
        }

        .modal-content {
            width: 90%;
            max-width: 800px; /* Limit modal width */
            max-height: 80vh; /* Prevent overflow */
            overflow-y: auto; /* Add scroll if content overflows */
            background: white;
            padding: 20px;
            border-radius: 8px;
        }

        .close-btn {
            cursor: pointer;
            color: red;
            float: right;
            font-size: 24px;
        }

        #transactionSummary {
            margin-top: 20px;
        }

        table {
            margin-top: 20px;
        }
    </style>
    <script src="js/TransactionAPIHandler.js"></script> <!-- Ensure this is the correct path -->
</head>
<body>
    <!-- Trigger button for the modal -->
    <button id="openModalBtn" class="btn btn-primary">Enter Loyalty ID</button>

    <!-- Modal -->
    <div id="loyaltyModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeModalBtn">&times;</span>
            <h2>Loyalty Transaction Summary</h2>

            <!-- Form inside modal -->
            <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>

            <form id="loyaltyForm">
                <label for="loyaltyId">Loyalty ID:</label>
                <input type="text" id="loyaltyId" name="loyaltyCardUID" class="form-control" placeholder="Enter your Loyalty ID" required>
                <button type="submit" class="btn btn-success mt-3">Submit</button>
            </form>

            <!-- Transaction summary will be rendered here -->
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

        // Close modal when clicking outside the modal content
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Loyalty form submission
        loyaltyForm.addEventListener('submit', async (event) => {
            event.preventDefault(); // Prevent default form submission
            alert("Submit button clicked and loyalty ID submitted!");

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

        // Function to display error messages
        function displayError(message) {
            errorMessage.style.display = 'block';
            errorMessage.textContent = message;
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 3000);
        }

        // Function to render the Loyalty Card data
        function renderLoyaltyCard(transactions) {
    // If no transactions are provided, show a message
    if (!transactions || transactions.length === 0) {
        transactionSummary.innerHTML = '<p>No transactions found for the provided Loyalty ID.</p>';
        return;
    }

    // Create the table HTML
    let transactionsHtml = `
        <h3>Transaction Summary for Loyalty Card</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Total Points Used</th>
                    <th>Points Earned</th>
                </tr>
            </thead>
            <tbody>
    `;

    // Iterate over the transactions array to build table rows
    transactions.forEach(transaction => {
        transactionsHtml += `
            <tr>
                <td>${transaction.UserUniqueIdentifier}</td>
                <td>${transaction.TotalPointsUsed}</td>
                <td>${transaction.PointsEarned}</td>
            </tr>
        `;
    });

    transactionsHtml += `</tbody></table>`;

    // Insert the table into the DOM
    transactionSummary.innerHTML = transactionsHtml;
}

    </script>
</body>
</html>
