<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoyaltyCardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\ReportController;

// Route for the login page (GET)
Route::get('/', function () {
    return view('login'); // Show the login page by default
})->name('login');

// Route for authentication (POST)
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');

// Protected routes that require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', function () {
        return view('checkout'); // Show the checkout page
    })->name('checkout');
});

// Route for handling the payment logic (POST)
Route::post('/', function (\Illuminate\Http\Request $request) {
    // Retrieve the products and loyalty points data from the form submission
    $products = $request->input('products', []); // Products array
    $loyaltyPoints = $request->input('loyalty_points', 0); // Loyalty points

    // You can add your payment logic here (e.g., processing payment, reducing points)

    // For now, we just return a success response
    return response()->json([
        'success' => true,
        'message' => 'Purchase Successful!', // You can customize the message here
    ]);
})->name('payment');

//Route::post('/transactions/store', [TransactionController::class, 'storeTransaction'])->name('transactions.store');

// Route ng Validate product, kung meron talagang ganung product sa database
Route::post('/validate-product', [ProductController::class, 'validateProductCode']);

Route::get('/loyalty-cards', function () {
    return view('loyaltycards');
});

Route::get('/update-loyalty-cards', function () {
    return view('update-loyalty-cards');
});

Route::get('/staff-menu', function () {
    return view('staff-menu');
});

Route::get('/admin-menu', function () {
    return view('admin-menu');
});

Route::get('/order-add', function () {
    return view('order_post');
});

Route::get('/test-transaction', function () {
    return view('test-transaction');
});

Route::get('/userManage', function () {
    return view('userManage');
})->name('userManage');

Route::get('/select-report-type', function () {
    return view('selectReportType');
})->name('selectReportType');

Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::post('/register', [AuthController::class, 'registerUser']);

Route::get('/login',[ AuthController::class, 'login']) -> name('login');

Route::post('/login', [AuthController::class, 'authenticate']);

Route::post('/logout', [AuthController::class, 'logout']) -> name('logout');

Route::post('/logout', [AuthController::class, 'logout']) -> name('logout');

Route::get('/userManage', [UserController::class, 'index'])->name('userManage');

Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::delete('/users', [UserController::class, 'destroyMultiple'])->name('users.destroyMultiple');

Route::get('/get-newest-order-id', [OrderController::class, 'getNewestOrderId']);

Route::get('/generate-report', [ReportController::class, 'generateReport'])->name('generateReport');
Route::get('/report', [ReportController::class, 'generateReport'])->name('generateReport');
Route::post('/reports/generate', [ReportController::class, 'generateReport'])->name('generateReport');

// TEST ROUTE
Route::get('/order-products', [OrderProductController::class, 'index']);
