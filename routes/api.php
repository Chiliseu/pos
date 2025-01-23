<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\TokenController;

Route::post('/generate-token', [TokenController::class, 'generateToken']);

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LoyaltyCardsController;



// Protect these routes using Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('transactions', TransactionController::class);

    Route::get('order-products', [OrderProductController::class, 'indexJSON']);
    Route::post('order-products', [OrderProductController::class, 'store']);
    Route::get('order-products/{orderID}/{productID}', [OrderProductController::class, 'show']);
    Route::put('order-products/{orderID}/{productID}', [OrderProductController::class, 'update']);
    Route::delete('order-products/{orderID}/{productID}', [OrderProductController::class, 'destroy']);

    Route::get('/users', [UserController::class, 'indexJSON'])->name('users.index'); // Show all users
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show'); // Show a single user by ID
    Route::post('/users', [UserController::class, 'store'])->name('users.store'); // Store a new user
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update'); // Update an existing user
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy'); // Delete a user

    Route::apiResource('user-roles', UserRoleController::class);
    Route::get('transactions/loyalty/{loyaltyCardID}', [TransactionController::class, 'getByLoyaltyCardID']);
    //Route::post('/reports/generate', [ReportController::class, 'generateReport'])->name('generateReport');

    Route::get('/report/loyalty-transaction-summary', [ReportController::class, 'getLoyaltyTransactionSummary']);
    Route::get('/report/customer-points-summary', [ReportController::class, 'getCustomerPointsSummary']);
    Route::get('/report/product-performance', [ReportController::class, 'getProductPerformance']);
    Route::get('/report/loyalty-customer-history', [ReportController::class, 'getLoyaltyCustomerHistory']);

    Route::get('/transactions', [TransactionController::class, 'index']);
    //Route::get('/loyaltycards', [LoyaltyCardsController::class, 'index']);
    //Route::get('/product-performance', [ProductPerformanceController::class, 'index']);
    //Route::get('/loyalty-customer-history', [CustomerHistoryController::class, 'index']);


});
