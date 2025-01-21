<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Dipensa Teknolohiya Grocery - Admin Menu</title>
        <link rel="stylesheet" href="/css/menu.css">
        <link rel="icon" type="image/png" href="/Picture/StoreLogo.png">
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

                <!-- User Management Button -->
                <form action="{{ route('userManage') }}">
                    <button type="submit">User Management</button>
                </form>

                <!-- Select Report Type Button -->
                <form action="{{ route('selectReportType') }}">
                    <button type="submit" class="Reportbtn" disabled>Generate Report</button>
                </form>

                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" id="logout-btn">Logout</button>
                </form>
            </div>

        </div>
    </body>
</html>
