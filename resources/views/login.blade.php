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
        <h2>Login Form</h2>

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div>
                <label for="email"><b>Email</b></label>
                <input type="email" name="email" id="email" placeholder="Enter Email" required>
            </div>

            <div>
                <label for="password"><b>Password</b></label>
                <input type="password" name="password" id="password" placeholder="Enter Password" required>
            </div>

            <button type="submit">Login</button>
            <button type="reset" class="clearbtn">Clear</button> <!-- Clear Button -->
        </form>

        <!-- Display Success Message -->
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    
    <script>
        // Clear Form Functionality
        document.querySelector('.clearbtn').addEventListener('click', function() {
            document.getElementById('email').value = '';
            document.getElementById('password').value = '';
        });
    </script>

</body>
</html>
