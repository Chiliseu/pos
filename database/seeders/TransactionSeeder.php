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
            'UniqueIdentifier' => $this->generateUniqueIdentifier(),
        ]);

        Transaction::create([
            'OrderID' => 2,
            'UserID' => 2,
            'LoyaltyCardID' => 2,
            'TotalPointsUsed' => 200,
            'PointsEarned' => 100,
            'TransactionDate' => now(),
            'UniqueIdentifier' => $this->generateUniqueIdentifier(),
        ]);

        Transaction::create([
            'OrderID' => 3,
            'UserID' => 1,
            'LoyaltyCardID' => 1,
            'TotalPointsUsed' => 150,
            'PointsEarned' => 75,
            'TransactionDate' => now(),
            'UniqueIdentifier' => $this->generateUniqueIdentifier(),
        ]);

        Transaction::create([
            'OrderID' => 4,
            'UserID' => 1,
            'LoyaltyCardID' => 1,
            'TotalPointsUsed' => 120,
            'PointsEarned' => 60,
            'TransactionDate' => now(),
            'UniqueIdentifier' => $this->generateUniqueIdentifier(),
        ]);

        Transaction::create([
            'OrderID' => 5,
            'UserID' => 2,
            'LoyaltyCardID' => 2,
            'TotalPointsUsed' => 250,
            'PointsEarned' => 125,
            'TransactionDate' => now(),
            'UniqueIdentifier' => $this->generateUniqueIdentifier(),
        ]);

        Transaction::create([
            'OrderID' => 6,
            'UserID' => 2,
            'LoyaltyCardID' => 2,
            'TotalPointsUsed' => 180,
            'PointsEarned' => 90,
            'TransactionDate' => now(),
            'UniqueIdentifier' => $this->generateUniqueIdentifier(),
        ]);
    }

    private function generateUniqueIdentifier()
    {
        $randomLetter = chr(rand(65, 90)); // Generate a random uppercase letter
        $randomNumber = rand(1000, 9999); // Generate a random number
        return 'TRS-' . $randomLetter . $randomNumber;
    }
}
