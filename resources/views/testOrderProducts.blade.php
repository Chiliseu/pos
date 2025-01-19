<!DOCTYPE html>
<html>
<head>
    <title>Order Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <h1>Order Products</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderProducts as $orderProduct)
                <tr>
                    <td>{{ $orderProduct->OrderID }}</td>
                    <td>{{ $orderProduct->ProductID }}</td>
                    <td>{{ $orderProduct->Quantity }}</td>
                    <td>{{ $orderProduct->TotalPrice }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>