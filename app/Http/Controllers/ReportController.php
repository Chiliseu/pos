<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Http;
//use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function selectReportType()
    {
        return view('selectReportType');
    }
    
    /**
     * Generate a report based on the provided report type.
     */
    public function generateReport(Request $request)
    {
        // Get the report type from the request
        $reportType = $request->input('reportType');
        return view('generatedReportView', ['reportType' => $reportType]);

        // Route to the appropriate method based on the report type
        switch ($reportType) {
            case 'loyaltyTransactionSummary':
                return $this->getLoyaltyTransactionSummary($request);

            case 'customerPointsSummary':
                return $this->getCustomerPointsSummary($request);

            case 'productPerformance':
                return $this->getProductPerformance($request);

            case 'loyaltyCustomerHistory':
                return $this->getLoyaltyCustomerHistory($request);

            default:
                return response()->json([
                    'error' => 'Invalid report type provided.'
                ], 400);
        }
    }
    /**
     * Fetch Loyalty Transaction Summary.
     */
    public function getLoyaltyTransactionSummary(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $userId = $request->input('userId');
        $loyaltyCardId = $request->input('loyaltyCardId');

        $data = DB::table('transactions')
            ->select(
                'transactions.TransactionID',
                'transactions.TransactionDate',
                DB::raw("CONCAT_WS(' ', users.Firstname, users.Lastname) AS CustomerName"),
                'transactions.LoyaltyCardID',
                'transactions.PointsEarned',
                'transactions.TotalPointsUsed',
                'orders.OrderID',
                'orders.Total'
            )
            ->join('orders', 'transactions.OrderID', '=', 'orders.OrderID')
            ->join('users', 'transactions.UserID', '=', 'users.id')
            ->whereBetween('transactions.TransactionDate', [$startDate, $endDate])
            ->when($userId, function ($query, $userId) {
                return $query->where('transactions.UserID', $userId);
            })
            ->when($loyaltyCardId, function ($query, $loyaltyCardId) {
                return $query->where('transactions.LoyaltyCardID', $loyaltyCardId);
            })
            ->get();

        return response()->json($data);
    }

    /**
     * Fetch Customer Points Summary.
     */
    public function getCustomerPointsSummary(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $data = DB::table('users')
            ->select(
                'users.id',
                'users.Firstname',
                'users.Lastname',
                'users.email',
                DB::raw("CONCAT_WS(' ', users.Firstname, users.Lastname) AS CustomerName"),
                DB::raw('SUM(COALESCE(transactions.PointsEarned, 0)) AS TotalPointsEarned'),
                DB::raw('SUM(COALESCE(transactions.TotalPointsUsed, 0)) AS TotalPointsUsed'),
                DB::raw('SUM(COALESCE(transactions.PointsEarned, 0)) - SUM(COALESCE(transactions.TotalPointsUsed, 0)) AS RemainingPoints')
            )
            ->leftJoin('transactions', 'users.id', '=', 'transactions.UserID')
            ->join('user_roles', 'users.UserRoleID', '=', 'user_roles.UserRoleID')
            ->where('user_roles.RoleName', 'Staff') // Adjust this based on your actual role names
            ->whereBetween('users.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.Firstname', 'users.Lastname', 'users.email')
            ->get();

        return response()->json($data);
    }

    /**
     * Fetch Product Performance for Loyalty Customers.
     */
    public function getProductPerformance(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $productId = $request->input('productId');
        $categoryId = $request->input('categoryId');

        $data = DB::table('orders')
            ->select(
                'product.ProductID',
                'product.Name as ProductName',
                'category.CategoryID',
                'category.Name as CategoryName',
                DB::raw('SUM(order_products.Quantity) as TotalQuantitySold'),
                DB::raw('SUM(order_products.TotalPrice) as TotalRevenue')
            )
            ->join('order_products', 'orders.OrderID', '=', 'order_products.OrderID')
            ->join('product', 'order_products.ProductID', '=', 'product.ProductID')
            ->join('category', 'product.CategoryID', '=', 'category.CategoryID')
            ->whereBetween('orders.OrderDate', [$startDate, $endDate])
            ->when($productId, function ($query, $productId) {
                return $query->where('product.ProductID', $productId);
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category.CategoryID', $categoryId);
            })
            ->groupBy('product.ProductID', 'product.Name', 'category.CategoryID', 'category.Name')
            ->get();

        return response()->json($data);
    }

    /**
     * Fetch Loyalty Customer Purchase History.
     */
    public function getLoyaltyCustomerHistory(Request $request)
    {
        // Validate the input fields
        $validated = $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'customerId' => 'nullable|integer|exists:users,id',
        ]);

        // Extract filters from the validated data
        $startDate = $validated['startDate'];
        $endDate = $validated['endDate'];
        $customerId = $validated['customerId'] ?? null;

        // Query the database
        $data = DB::table('orders')
            ->select(
                'orders.OrderID',
                'orders.OrderDate',
                DB::raw("CONCAT_WS(' ', users.Firstname, users.Lastname) AS CustomerName"),
                'product.Name as ProductName',
                'order_products.Quantity',
                'order_products.TotalPrice'
            )
            ->join('order_products', 'orders.OrderID', '=', 'order_products.OrderID')
            ->join('product', 'order_products.ProductID', '=', 'product.ProductID')
            ->join('transactions', 'orders.OrderID', '=', 'transactions.OrderID')
            ->join('users', 'transactions.UserID', '=', 'users.id')
            ->whereBetween('orders.OrderDate', [$startDate, $endDate])
            ->when($customerId, function ($query, $customerId) {
                return $query->where('users.id', $customerId);
            })
            ->get();

        // Return the data to the view
        return view('generateReport', [
            'reportType' => 'Loyalty Customer Purchase History',
            'data' => $data,
            'headers' => ['Customer Name', 'Product', 'Quantity', 'Total Price', 'Date']
        ]);
    }
}