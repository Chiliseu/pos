<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Transaction Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #transactionSummary {
            margin-top: 20px;
        }

        table {
            margin: 20px;
        }

        /* Back button styling */
        .backBtn {
            margin: 20px 0;
            margin-left: 0px;
            width: 100%;
            text-align: left;
        }

        .backBtn a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            background-color: #2b4b2f; /* Dark green background */
            border: 2px solid #2b4b2f; /* Dark green border */
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .backBtn:hover {
            /* scale up */
            transform: scale(1.1);
            width: 250px;
            margin: 20px 0;
            margin-left: 0px;
            transition: ease 0.5s;
        }

        .backBtn:hover a span.back {
            display: inline-block;
        }

        .backBtn a span.back {
            display: none;
        }

        .backBtn a:hover {
            background-color: #1f3622; /* Darker green on hover */
            color: white;
            text-decoration: none;
            transform: scale(1.1); /* Slight scaling effect */
        }

        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: top;
            height: 100vh;
        }
        .container {
            margin-top: 20px;
            width: 80%;
            max-width: 1400px;
            max-height: 80vh; /* Prevent overflow */
            margin-left: auto;
            margin-right: auto;
            border: 1px solid #ccc;
            border-radius: 20px;
            box-shadow: 1px 1px 20px 4px rgba(0, 0, 0, 0.4);
            padding:20px;
        }

        .header {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 20px;
            color: #2b4b2f;
            width:100%;
        }

        .table-container {
            overflow-y: auto;
            margin-top: 50px;
            max-height: 500px;
            width: 80%;
            max-width: 1400px;
            margin-bottom: 20px;
            border-style: ridge;
            border-width: 0px;
            border-color: #2b4b2f;
            padding: 10px;
            justify-content: center; /* Center horizontally */
            border-radius: 20px;
        }

        .table-container table {
            width: 95%;
        }
    </style>
    <script src="{{ asset('js/TransactionAPIHandler.js') }}"></script> <!-- Ensure this is the correct path -->
</head>
<body>
    <!-- Back Buttons-->
    <div class="backBtn">
        <a href="javascript:history.back()" id="back">&larr; <span class="back">Back</span></a>
    </div>

    <div class="main-container">
        <div class="container"> 
        <div class="header">
            <h2>Loyalty Transaction Summary</h2>
        </div>
    
        <!-- Form -->
        <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>

        <form id="loyaltyForm">
            <label for="loyaltyId">Loyalty ID:</label>
            <input type="text" id="loyaltyId" name="loyaltyCardUID" class="form-control" placeholder="Enter your Loyalty ID" required>
            <button type="submit" class="btn btn-success mt-3">Submit</button>
        </form>
        </div>

        <!-- Transaction summary will be rendered here -->
        <div class="table-container">
            <hr>
            <div id="transactionSummary"></div>
        </div>
    </div>
    
    

    <script>
        const loyaltyForm = document.getElementById('loyaltyForm');
        const errorMessage = document.getElementById('errorMessage');
        const transactionSummary = document.getElementById('transactionSummary');

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
                displayError(error.message || 'An error occurred while fetching the data.');
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

            // Iterate over the transactions array to build table rows
            transactions.forEach(transaction => {
                transactionsHtml += `
                    <tr>
                        <td>${transaction.TransactionUniqueIdentifier}</td>
                        <td>${transaction.OrderUniqueIdentifier}</td>
                        <td>${transaction.UserUniqueIdentifier}</td>
                        <td>${transaction.TotalPointsUsed}</td>
                        <td>${transaction.PointsEarned}</td>
                        <td>${transaction.TransactionDate || 'N/A'}</td>
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