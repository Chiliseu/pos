<?php
    use Illuminate\Support\Facades\Auth;
    $loginAttempts = session()->get('loginAttempts',0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dipensa Teknolohiya Grocery - Login</title>
    <link rel="stylesheet" href="/css/login.css">
    <link rel="icon" type="image/png" href="/Picture/StoreLogo.png">
</head>
<body>

    <div class="login-container">
        <!-- Logo -->
        <img src="/Picture/StoreLogo.png" alt="Store Logo" class="logo">
        <h1>Dipensa Teknolohiya Grocery</h1>

        <!-- Login Form -->
        <form action="{{ route('authenticate') }}" method="POST">
            @csrf
            <div>
                <label for="email">Email <span style="color: red; font-size: 15px"> *</span></label>
                <input type="email" name="email" id="email" placeholder="Enter Email" required>
            </div>

            <div>
                <label for="password">Password <span style="color: red; font-size: 15px"> *</span></label>
                <input type="password" name="password" id="password" placeholder="Enter Password" required>
            </div>
            
            <button type="submit" id="loginButton" {{ $loginAttempts >= 5 ? 'disabled' : '' }}>Login</button>
            <button type="reset" class="clearbtn">Clear</button> <!-- Clear Button -->
            <p>You have {{ 5 - $loginAttempts }} login attempts remaining</p>
        </form>

        <!-- Display Success Message -->
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <h3>{!! $error !!}</h3>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        let loginAttempts = @json($loginAttempts);
        const loginButton = document.getElementById('loginButton');

        function disableLoginButton() {
            loginButton.disabled = true;
            setTimeout(() => {
                loginButton.disabled = false;
                // Reset login attempts after 1 minute
                fetch('/reset-login-attempts', { 
                    method: 'POST', 
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                    } 
                }).then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        console.log('Login attempts reset successfully');
                        window.location.reload(); // Reload the page
                    } else {
                        console.error('Failed to reset login attempts');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });
            }, 60000); // Disable for 1 minute
        }

        if (loginAttempts >= 5) {
            disableLoginButton();
        }

        // Clear Form Functionality
        document.querySelector('.clearbtn').addEventListener('click', function() {
            document.getElementById('email').value = '';
            document.getElementById('password').value = '';
        });
    });
    </script>
</body>
</html>