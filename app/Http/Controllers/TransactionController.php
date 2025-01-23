<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // For generating UniqueIdentifier

class TransactionController extends Controller
{
    public function index()
    {
        return Transaction::all();
    }

    public function getByLoyaltyCardID($loyaltyCardUID)
    {
                // Check if a LoyaltyCard with the provided UniqueIdentifier exists
        $loyaltyCard = LoyaltyCard::where('UniqueIdentifier', $loyaltyCardUID)->first();

        if (!$loyaltyCard) {
            return response()->json(['error' => 'Loyalty Card not found'], 404);
        }

        // Fetch transactions associated with the LoyaltyCard
        $transactions = Transaction::with(['order', 'user', 'loyaltyCard'])
            ->where('LoyaltyCardID', $loyaltyCard->LoyaltyCardID)
            ->get();

        if ($transactions->isEmpty()) {
            return response()->json(['error' => 'No transactions found for the provided Loyalty Card'], 404);
        }

        // Format the response to include all transactions
        $response = $transactions->map(function ($transaction) {
            return [
                'TransactionUniqueIdentifier' => $transaction->UniqueIdentifier,
                'OrderUniqueIdentifier' => $transaction->order->UniqueIdentifier ?? null,
                'UserUniqueIdentifier' => $transaction->user->UniqueIdentifier ?? null,
                'LoyaltyCardUniqueIdentifier' => $transaction->loyaltyCard->UniqueIdentifier ?? null,
                'TotalPointsUsed' => $transaction->TotalPointsUsed,
                'PointsEarned' => $transaction->PointsEarned,
                'TransactionDate' => $transaction->TransactionDate,
            ];
        });

        return response()->json($response, 200);
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
