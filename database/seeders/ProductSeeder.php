<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 1,
                    'Name' => 'Banana',
                    'Price' => 15.00,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 1,
                    'Name' => 'Carrot',
                    'Price' => 21.00,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 1,
                    'Name' => 'Broccoli',
                    'Price' => 5.00,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 1,
                    'Name' => 'Potato',
                    'Price' => 10.00,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            
                // Dairy & Eggs
                [
                    'CategoryID' => 2, // Assuming category with ID 2 is 'Dairy & Eggs'
                    'Name' => 'Milk (1L)',
                    'Price' => 59.99,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 2,
                    'Name' => 'Cheddar Cheese (200g)',
                    'Price' => 300.99,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 2,
                    'Name' => 'Eggs (Dozen)',
                    'Price' => 199.99,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 2,
                    'Name' => 'Yogurt (500g)',
                    'Price' => 150.49,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 2,
                    'Name' => 'Butter (250g)',
                    'Price' => 80.99,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            
                // Bakery & Bread
                [
                    'CategoryID' => 3, // Assuming category with ID 3 is 'Bakery & Bread'
                    'Name' => 'Sliced Bread',
                    'Price' => 5.50,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 3,
                    'Name' => 'Croissant',
                    'Price' => 69.96,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 3,
                    'Name' => 'Bagel',
                    'Price' => 420.89,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 3,
                    'Name' => 'Dinner Rolls (6 pcs)',
                    'Price' => 50.49,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 3,
                    'Name' => 'Muffin',
                    'Price' => 65,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            
                // Meat & Seafood
                [
                    'CategoryID' => 4, // Assuming category with ID 4 is 'Meat & Seafood'
                    'Name' => 'Chicken Breast (1kg)',
                    'Price' => 250.00,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 4,
                    'Name' => 'Ground Beef (1kg)',
                    'Price' => 350.00,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 4,
                    'Name' => 'Salmon Fillet (500g)',
                    'Price' => 400.00,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 4,
                    'Name' => 'Shrimp (500g)',
                    'Price' => 450.00,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 4,
                    'Name' => 'Pork Chops (1kg)',
                    'Price' => 300.00,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            
                // Pantry Essentials
                [
                    'CategoryID' => 5, // Assuming category with ID 5 is 'Pantry Essentials'
                    'Name' => 'Rice (5kg)',
                    'Price' => 250.99,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 5,
                    'Name' => 'Pasta (500g)',
                    'Price' => 52.49,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 5,
                    'Name' => 'Canned Tuna (185g)',
                    'Price' => 53.80,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 5,
                    'Name' => 'Cooking Oil (1L)',
                    'Price' => 180.99,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'CategoryID' => 5,
                    'Name' => 'Salt (1kg)',
                    'Price' => 49.01,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],            
            // Add more products as needed
        ]);
    }
}
