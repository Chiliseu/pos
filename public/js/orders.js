async function addOrder(subtotal, total) {
    try {
        // Step 1: Format the current date as YYYY-MM-DD
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Month is 0-based
        const day = String(currentDate.getDate()).padStart(2, '0');
        const formattedDate = `${year}-${month}-${day}`;

        // Step 2: Generate the Bearer Token
        const tokenResponse = await fetch('https://pos-production-c2c1.up.railway.app/api/generate-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        });

        if (!tokenResponse.ok) {
            const errorData = await tokenResponse.json();
            throw new Error(`Token generation failed: ${errorData.message || 'Unknown error'}`);
        }

        const tokenData = await tokenResponse.json();
        const bearerToken = tokenData.token;

        // Step 3: Add the Order using the Bearer Token
        const orderData = {
            OrderDate: formattedDate,  // Use the formatted current date
            Subtotal: subtotal,
            Total: total,
        };

        const orderResponse = await fetch('https://pos-production-c2c1.up.railway.app/api/orders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${bearerToken}`,
            },
            body: JSON.stringify(orderData),
        });

        if (!orderResponse.ok) {
            const errorData = await orderResponse.json();
            throw new Error(`Order creation failed: ${errorData.message || 'Unknown error'}`);
        }

        const orderResult = await orderResponse.json();
        console.log('Order created:', orderResult);

        // Return the order result to the caller
        return orderResult; // This will return the newly created order data

    } catch (error) {
        console.error('Error:', error);
        // Optionally, return null or some error message on failure
        return null; // Return null or an error message on failure
    }
}

async function addOrderProduct(orderID, productID, quantity, totalPrice) {
    try {
        // Step 1: Generate the Bearer Token
        const tokenResponse = await fetch('https://pos-production-c2c1.up.railway.app/api/generate-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        });

        if (!tokenResponse.ok) {
            const errorData = await tokenResponse.json();
            throw new Error(`Token generation failed: ${errorData.message || 'Unknown error'}`);
        }

        const tokenData = await tokenResponse.json();
        const bearerToken = tokenData.token;

        // Step 2: Add the Order Product using the Bearer Token
        const orderProductData = {
            OrderID: orderID,
            ProductID: productID,
            Quantity: quantity,
            TotalPrice: totalPrice,
        };

        const orderProductResponse = await fetch('https://pos-production-c2c1.up.railway.app/api/order-products', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${bearerToken}`,
            },
            body: JSON.stringify(orderProductData),
        });

        if (!orderProductResponse.ok) {
            const errorData = await orderProductResponse.json();
            throw new Error(`Order product addition failed: ${errorData.message || 'Unknown error'}`);
        }

        const orderProductResult = await orderProductResponse.json();
        console.log('Order product added:', orderProductResult);
        
    } catch (error) {
        console.error('Error adding order product:', error);
        throw error;
    }
}