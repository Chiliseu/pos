<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Transaction Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            font-weight: bold;
            color: #333;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-btn:hover {
            color: #ff0000;
        }

        table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Loyalty Transaction Summary</h1>
        <!-- Trigger button for the modal -->
        <button id="openModalBtn" class="btn btn-primary">Enter Loyalty ID</button>

        <!-- Modal -->
        <div id="loyaltyModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" id="closeModalBtn">&times;</span>
                <h2>Enter Loyalty ID</h2>
                <form id="loyaltyForm" action="/get-transaction-summary" method="GET">
                    <label for="loyaltyId">Loyalty ID:</label>
                    <input type="text" id="loyaltyId" name="loyaltyCardUID" placeholder="Enter your Loyalty ID" required>
                    <button type="submit" class="btn btn-success w-100 mt-3">Submit</button>
                </form>
            </div>
        </div>

        <!-- Table to display transactions -->
        <div id="transactionResults" class="mt-4">
            <!-- The transactions will be populated here -->
        </div>
    </div>

    <script>
        const modal = document.getElementById('loyaltyModal');
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const transactionResults = document.getElementById('transactionResults');

        openModalBtn.addEventListener('click', () => {
            modal.style.display = 'flex';
        });

        closeModalBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Handle form submission
        document.getElementById('loyaltyForm').addEventListener('submit', async (event) => {
            event.preventDefault();
            const loyaltyId = document.getElementById('loyaltyId').value;

            try {
                const response = await fetch(`/get-transaction-summary?loyaltyCardUID=${loyaltyId}`);
                if (!response.ok) {
                    transactionResults.innerHTML = '<p class="text-danger">Failed to fetch transactions.</p>';
                    return;
                }

                const transactions = await response.json();
                if (transactions.error) {
                    transactionResults.innerHTML = `<p class="text-danger">${transactions.error}</p>`;
                    return;
                }

                const table = `
                    <table>
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Order ID</th>
                                <th>User ID</th>
                                <th>Points Used</th>
                                <th>Points Earned</th>
                                <th>Transaction Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${transactions.map(transaction => `
                                <tr>
                                    <td>${transaction.TransactionUniqueIdentifier}</td>
                                    <td>${transaction.OrderUniqueIdentifier}</td>
                                    <td>${transaction.UserUniqueIdentifier}</td>
                                    <td>${transaction.TotalPointsUsed}</td>
                                    <td>${transaction.PointsEarned}</td>
                                    <td>${transaction.TransactionDate}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                `;
                transactionResults.innerHTML = table;
                modal.style.display = 'none';
            } catch (error) {
                transactionResults.innerHTML = '<p class="text-danger">An error occurred while fetching transactions.</p>';
            }
        });
    </script>
</body>
</html>
