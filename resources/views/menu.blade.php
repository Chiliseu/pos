<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Dipensa Teknolohiya Grocery - Login</title>
        <link rel="stylesheet" href="/css/menu.css">
        <link rel="icon" type="image/png" href="/Picture/StoreLogo.png">
    </head>

    <body>
        <div class="menulogo-container">
            <!-- Logo -->
            <img src="/Picture/StoreLogo.png" alt="Store Logo" class="logo">
            <h1>Dipensa Teknolohiya Grocery</h1>
        </div>

        @if ($condition)
            <div class="menubtn-container">
                <!-- Menu Button -->
                <button>Point-of-Sale</button>
                <button>User Management</button>
                <button>Logout</button>
            </div>
        @else
            <div class="alternative-container">
                <!-- Alternative content -->
                <button>Point-of-Sale</button>
                <button>Logout</button>
            </div>
        @endif
       
    </body>
</html>