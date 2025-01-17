<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
</head>
<body>

<!-- Order Form -->
<form id="orderForm">
    <div>
        <label for="Subtotal">Subtotal:</label>
        <input type="number" step="0.01" id="Subtotal" name="Subtotal" required>
    </div>
    <div>
        <label for="Total">Total:</label>
        <input type="number" step="0.01" id="Total" name="Total" required>
    </div>
    <button type="submit">Create Order</button>
</form>

<!-- Include the external JS file -->
<script src="js/orders.js"></script>

<script>
    // Handle form submission
    document.getElementById('orderForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Get the values from the form
        const subtotal = parseFloat(document.getElementById('Subtotal').value) || 0;
        const total = parseFloat(document.getElementById('Total').value) || 0;

        // Call the addOrder function with subtotal and total
        addOrder(subtotal, total);
    });
</script>

</body>
</html>
