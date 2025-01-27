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

    Route::get('/userManage', [UserController::class, 'index'])->name('userManage');

    Route::get('/select-report-type', function () {
        return view('selectReportType');
    })->name('selectReportType');
    
    Route::post('/customerPointsSummary', function () {
        return view('customerPointsSummary');
    })->name('customerPointsSummary');
    
    Route::post('/loyaltyTransactionSummary', function () {
        return view('loyaltyTransactionSummary');
    })->name('loyaltyTransactionSummary');
    
    Route::post('/productPerformance', function () {
        return view('productPerformance');
    })->name('productPerformance');
    
    Route::get('/transactionSummary', function () {
        return view('transactionSummary');
    })->name('transactionSummary');
    
    Route::post('/generate-report', [ReportController::class, 'generateReport'])->name('generateReport');
    Route::post('/reports/generate', [ReportController::class, 'generateReport'])->name('generateReport');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
    Route::delete('/users', [UserController::class, 'destroyMultiple'])->name('users.destroyMultiple');
    
    Route::get('/get-newest-order-id', [OrderController::class, 'getNewestOrderId']);
    
    Route::get('/transaction-summary', [TransactionController::class, 'showTransactionSummary'])->name('transactionSummary');
    Route::get('/transaction-summary-report', [TransactionController::class, 'showTransactionSummary'])->name('transactionSummaryReport');
    Route::get('/customer-points-summary', [TransactionController::class, 'customerPointsSummary']);
});

Route::get('/latest-transactions', [TransactionController::class, 'getLatestTransactions']);

Route::get('/top-product', [ProductController::class, 'getTopProduct']);

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

// Route for validating product codes
Route::post('/validate-product', [ProductController::class, 'validateProductCode']);

// Route for displaying loyalty cards
Route::get('/loyalty-cards', function () {
    return view('loyaltycards');
});

// Route for updating loyalty cards
Route::get('/update-loyalty-cards', function () {
    return view('update-loyalty-cards');
});

// Route for registering a new user
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerUser']);

// Route for resetting login attempts
Route::post('/reset-login-attempts', [AuthController::class, 'resetLoginAttempts']);

// TEST ROUTE
Route::get('/order-products', [OrderProductController::class, 'index']);