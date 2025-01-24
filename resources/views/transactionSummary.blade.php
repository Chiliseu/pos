<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Transaction Summary</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Trigger button for the modal -->
    <button id="openModalBtn">Enter Loyalty ID</button>

    <!-- Modal -->
    <div id="loyaltyModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeModalBtn">&times;</span>
            <h2>Loyalty Transaction Summary</h2>
            <form id="loyaltyForm">
                <label for="loyaltyId">Loyalty ID:</label>
                <input type="text" id="loyaltyId" name="loyaltyId" placeholder="Enter your Loyalty ID" required>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
