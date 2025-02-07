<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Inserting products into the 'product' table
        DB::table('product')->insert([
            // Fruits & Vegetables
            [
                'CategoryID' => 1, // Assuming category with ID 1 is 'Fruits & Vegetables'
                'Name' => 'Apple',
                'Price' => 20.99,
                'UniqueIdentifier' => 'PRD-KKIBWY9Q', // PRD-Random letters/numbers
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'CategoryID' => 1,
                'Name' => 'Banana',
                'Price' => 15.00,
                'UniqueIdentifier' => 'PRD-GUHHLOB0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'CategoryID' => 1,
                'Name' => 'Carrot',
                'Price' => 21.00,
                'UniqueIdentifier' => 'PRD-61QS4AHU',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'CategoryID' => 1,
                'Name' => 'Broccoli',
                'Price' => 5.00,
                'UniqueIdentifier' => 'PRD-FYZII3KL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'CategoryID' => 1,
                'Name' => 'Potato',
                'Price' => 10.00,
                'UniqueIdentifier' => 'PRD-OZKVYMJO',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Dairy & Eggs
            [
                'CategoryID' => 2, // Assuming category with ID 2 is 'Dairy & Eggs'
                'Name' => 'Milk (1L)',
                'Price' => 59.99,
                'UniqueIdentifier' => 'PRD-NMHMBGBJ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'CategoryID' => 2,
                'Name' => 'Cheddar Cheese (200g)',
                'Price' => 300.99,
                'UniqueIdentifier' => 'PRD-EAVXMO2N',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'CategoryID' => 2,
                'Name' => 'Eggs (Dozen)',
                'Price' => 199.99,
                'UniqueIdentifier' => 'PRD-ZG3SR3UB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'CategoryID' => 2,
                'Name' => 'Yogurt (500g)',
                'Price' => 150.49,
                'UniqueIdentifier' => 'PRD-HA5UNLRP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'CategoryID' => 2,
                'Name' => 'Butter (250g)',
                'Price' => 80.99,
                'UniqueIdentifier' => 'PRD-UMONVVZH',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Add more products using the same pattern as needed...
        ]);
    }
}
