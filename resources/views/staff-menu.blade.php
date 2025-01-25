<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Dipensa Teknolohiya Grocery - Admin Menu</title>
        <link rel="stylesheet" href="/css/menu.css">
        <link rel="icon" type="image/png" href="/Picture/StoreLogo.png">

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modal = document.getElementById('WelcomeAdmin-Modal');
                modal.classList.add('show'); // Show the modal
                modal.style.display = 'flex'; // Ensure display is set to flex

                // Auto-dismiss the modal after 5 seconds (5000 milliseconds)
                setTimeout(function() {
                    modal.classList.remove('show');
                    modal.classList.add('out');
                    setTimeout(function() {
                        modal.style.display = 'none'; // Hide the modal after animation
                    }, 1000); // Match the duration of the transform transition
                }, 5000);
            });
        </script>
    </head>

    <body>
        <div class="container">
            <div class="menulogo-container">
                <!-- Logo -->
                <img src="/Picture/StoreLogo.png" alt="Store Logo" class="logo">
                <h1>Dipensa Teknolohiya Grocery</h1>
            </div>
            
            <div class="menubtn-container">
                <!-- Point-of-Sale Button -->
                <form action="{{ route('checkout') }}">
                    <button type="submit">Point-of-Sale</button>
                </form>
                    
                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" id="logout-btn">Logout</button>
                </form>
            </div>

        </div>
        <!----------MODAL ----------->
        <div class="modal" id="WelcomeAdmin-Modal">
            <div class="content-modal">
            <h2>WELCOME</h2>  
            <h3 id="username">{{ Auth::user()->name }}</h3>         
            <p>You are now logged in as Staff (^ v ^)</p>
            </div>
        </div>
    </body>
</html>