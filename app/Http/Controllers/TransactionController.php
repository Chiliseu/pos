<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // For generating UniqueIdentifier
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{
    public function index()
    {
        return Transaction::all();
    }

    public function getTransactionByLoyaltyCardUID($loyaltyCardUID)
    {
        // Remote API URL
        $baseUrl = 'https://loyalty-production.up.railway.app/api';
        $tokenUrl = $baseUrl . '/generate-token';
        $loyaltyCardUrl = $baseUrl . '/loyalty-cards/' . $loyaltyCardUID;
    
        try {
            // Step 1: Generate token
            $tokenResponse = Http::post($tokenUrl, []);
            if (!$tokenResponse->ok()) {
                return response()->json(['error' => 'Unable to generate token from loyalty system'], 500);
            }
    
            $token = $tokenResponse->json()['token'] ?? null;
            if (!$token) {
                return response()->json(['error' => 'Token not found in loyalty system response'], 500);
            }
    
            // Step 2: Fetch the LoyaltyCard data using the token
            $loyaltyCardResponse = Http::withToken($token)->get($loyaltyCardUrl);
    
            if ($loyaltyCardResponse->status() === 404) {
                return response()->json(['error' => 'Loyalty Card not found'], 404);
            }
    
            if (!$loyaltyCardResponse->ok()) {
                return response()->json(['error' => 'Failed to fetch Loyalty Card from loyalty system'], 500);
            }
    
            $loyaltyCard = $loyaltyCardResponse->json();
    
            // Step 3: Validate LoyaltyCard data
            if (!isset($loyaltyCard['LoyaltyCardID'])) {
                return response()->json(['error' => 'Invalid Loyalty Card data received from API'], 500);
            }
    
            $loyaltyCardID = $loyaltyCard['LoyaltyCardID'];
    
            // Step 4: Query transactions from the database (raw query)
            $transactions = DB::table('transactions')
            ->Join('orders', 'transactions.OrderID', '=', 'orders.OrderID')
            ->Join('users', 'transactions.UserID', '=', 'users.id')
            ->where('transactions.LoyaltyCardID', $loyaltyCardID)
            ->select(
                'orders.UniqueIdentifier as OrderUniqueIdentifier',
                'users.UniqueIdentifier as UserUniqueIdentifier',
                'transactions.TotalPointsUsed',
                'transactions.PointsEarned',
                'transactions.TransactionDate',
                'trasactions.UniqueIdentifier',
            )
            ->get();

            if ($transactions->isEmpty()) {
                return response()->json(['error' => 'No transactions found for the provided Loyalty Card'], 404);
            }
    
            // Step 5: Format the response
            $response = $transactions->map(function ($transaction) use ($loyaltyCardUID) {
                return [
                    'TransactionUniqueIdentifier' => $transaction->UniqueIdentifier ?? null,
                    'OrderUniqueIdentifier' => $transaction->OrderUniqueIdentifier ?? null,
                    'UserUniqueIdentifier' => $transaction->UserUniqueIdentifier ?? null,
                    'LoyaltyCardUniqueIdentifier' => $loyaltyCardUID,
                    'TotalPointsUsed' => $transaction->TotalPointsUsed ?? 0,
                    'PointsEarned' => $transaction->PointsEarned ?? 0,
                    'TransactionDate' => $transaction->TransactionDate ?? null,
                ];
            });
    
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'OrderID' => 'required|exists:orders,OrderID',
            'LoyaltyCardID' => 'required|integer',
            'UserID' => 'required|exists:users,id',
            'TotalPointsUsed' => 'required|integer',
            'PointsEarned' => 'required|integer',
            'TransactionDate' => 'required|date',
        ]);

        // Generate UniqueIdentifier for the transaction with 'TRS-' prefix
        $validated['UniqueIdentifier'] = strtoupper('TRS-' . Str::random(5)); // Format: TRS-Random

        // Create the transaction
        $transaction = Transaction::create($validated);

        return response()->json($transaction, 201);
    }

    public function show($id)
    {
        return Transaction::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $validated = $request->validate([
            'OrderID' => 'sometimes|exists:orders,OrderID',
            'LoyaltyCardID' => 'required|integer',
            'UserID' => 'required|exists:users,id',
            'TotalPointsUsed' => 'sometimes|integer',
            'PointsEarned' => 'sometimes|integer',
            'TransactionDate' => 'sometimes|date',
        ]);

        $transaction->update($validated);
        return response()->json($transaction);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted'], 204);
    }

    public function storeTransaction(Request $request)
    {
        // Retrieve the products from the request
        $products = $request->input('products');

        // Calculate subtotal and total based on the products
        $subtotal = 0;
        $total = 0;
        foreach ($products as $product) {
            $productData = json_decode($product, true);  // Decode the JSON data
            $subtotal += $productData['TotalPrice'];  // Assuming TotalPrice is one of the fields
            $total += $productData['TotalPrice'];     // Assuming TotalPrice is one of the fields
        }

        // Create the order
        $order = Order::create([
            'OrderDate' => now()->toDateString(),
            'Subtotal' => $subtotal,
            'Total' => $total,
        ]);

        // Add order products
        foreach ($products as $product) {
            $productData = json_decode($product, true);
            OrderProduct::create([
                'OrderID' => $order->OrderID,
                'ProductID' => $productData['ProductID'],
                'Quantity' => $productData['Quantity'],
                'TotalPrice' => $productData['TotalPrice'],
            ]);
        }

        // Create the transaction
        $transaction = Transaction::create([
            'OrderID' => $order->OrderID,
            'LoyaltyCardID' => $request->input('LoyaltyCardID'),
            'UserID' => $request->input('UserID'),
            'TotalPointsUsed' => $request->input('TotalPointsUsed'),
            'PointsEarned' => $request->input('PointsEarned'),
            'TransactionDate' => now()->toDateString(),
            'UniqueIdentifier' => 'TRS-' . Str::random(5), // Unique identifier for the transaction with 'TRS-' prefix
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaction completed successfully!',
            'transaction' => $transaction,
        ]);
    }
}
