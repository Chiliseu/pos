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
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
        }

        .modal-content {
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
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
    <script src="js/TransactionAPIHandler.js"></script> <!-- Ensure the correct path -->
</head>
<body>
    <button id="openModalBtn" class="btn btn-primary">Enter Loyalty ID</button>

    <div id="loyaltyModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeModalBtn">&times;</span>
            <h2>Loyalty Transaction Summary</h2>

            <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>

            <form id="loyaltyForm">
                <label for="loyaltyId">Loyalty ID:</label>
                <input type="text" id="loyaltyId" name="loyaltyCardUID" class="form-control" placeholder="Enter your Loyalty ID" required>
                <button type="submit" class="btn btn-success mt-3">Submit</button>
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

        loyaltyForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const loyaltyCardId = document.getElementById('loyaltyId').value;

            if (!loyaltyCardId) {
                displayError('Please enter a Loyalty Card ID.');
                return;
            }

            try {
                const loyaltySummaryData = await TransactionAPIHandler('fetchLoyaltySummary', loyaltyCardId);
                renderLoyaltySummary(loyaltySummaryData);
            } catch (error) {
                displayError(error || 'An error occurred while fetching the loyalty summary.');
            }
        });

        function renderLoyaltySummary(summary) {
            if (!summary) {
                transactionSummary.innerHTML = '<p>No loyalty summary found for the provided Loyalty ID.</p>';
                return;
            }

            transactionSummary.innerHTML = `
                <h3>Loyalty Points Summary</h3>
                <p>Total Points Earned: ${summary.totalPointsEarned || 0}</p>
                <p>Total Points Used: ${summary.totalPointsUsed || 0}</p>
                <p>Available Points: ${summary.availablePoints || 0}</p>
            `;
        }

        function displayError(message) {
            errorMessage.style.display = 'block';
            errorMessage.textContent = message;
        }
    </script>
</body>
</html>
