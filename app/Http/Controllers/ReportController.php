<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Http;
//use Illuminate\Support\Facades\Log;
use App\Services\LoyaltyService;

class ReportController extends Controller
{
    protected $loyaltyApi;

    public function __construct(LoyaltyService $loyaltyApi)
    {
        $this->loyaltyApi = $loyaltyApi;
    }

    public function getLoyaltyTransactionSummary(Request $request)
    {
        $filters = [
            'startDate' => $request->input('startDate', '1970-01-01'),
            'endDate' => $request->input('endDate', now()->toDateString()),
        ];

        try {
            $data = $this->loyaltyApi->getTransactions($filters);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function getCustomerPointsSummary(Request $request)
    {
        $filters = [
            'startDate' => $request->input('startDate', '1970-01-01'),
            'endDate' => $request->input('endDate', now()->toDateString()),
        ];

        try {
            $data = $this->loyaltyApi->getLoyaltyCards($filters);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function getProductPerformance(Request $request)
    {
        $filters = [
            'startDate' => $request->input('startDate', '1970-01-01'),
            'endDate' => $request->input('endDate', now()->toDateString()),
        ];

        try {
            $data = $this->loyaltyApi->getProductPerformance($filters);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function getLoyaltyCustomerHistory(Request $request)
    {
        $filters = [
            'startDate' => $request->input('startDate', '1970-01-01'),
            'endDate' => $request->input('endDate', now()->toDateString()),
        ];

        try {
            $data = $this->loyaltyApi->getLoyaltyCustomerHistory($filters);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}

/**
class ReportController extends Controller
{

    public function generateReport(Request $request)
    {
        // Get the report type from the request
        $reportType = $request->input('reportType');

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

    public function getLoyaltyCustomerHistory(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $customerId = $request->input('customerId');

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

        return response()->json($data);
    }
} */
