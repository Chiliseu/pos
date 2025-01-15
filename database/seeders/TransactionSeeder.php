<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        Transaction::create([
            'OrderID' => 1,
            'UserID' => 1,
            'LoyaltyCardID' => 1,
            'TotalPointsUsed' => 100,
            'PointsEarned' => 50,
            'TransactionDate' => now(),
        ]);

        Transaction::create([
            'OrderID' => 2,
            'UserID' => 2,
            'LoyaltyCardID' => 2,
            'TotalPointsUsed' => 200,
            'PointsEarned' => 100,
            'TransactionDate' => now(),
        ]);

        Transaction::create([
            'OrderID' => 3,
            'UserID' => 1,
            'LoyaltyCardID' => 1,
            'TotalPointsUsed' => 150,
            'PointsEarned' => 75,
            'TransactionDate' => now(),
        ]);

        Transaction::create([
            'OrderID' => 4,
            'UserID' => 1,
            'LoyaltyCardID' => 1,
            'TotalPointsUsed' => 120,
            'PointsEarned' => 60,
            'TransactionDate' => now(),
        ]);

        Transaction::create([
            'OrderID' => 5,
            'UserID' => 2,
            'LoyaltyCardID' => 2,
            'TotalPointsUsed' => 250,
            'PointsEarned' => 125,
            'TransactionDate' => now(),
        ]);

        Transaction::create([
            'OrderID' => 6,
            'UserID' => 2,
            'LoyaltyCardID' => 2,
            'TotalPointsUsed' => 180,
            'PointsEarned' => 90,
            'TransactionDate' => now(),
        ]);

        
    }
}
