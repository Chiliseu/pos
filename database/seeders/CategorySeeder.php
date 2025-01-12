<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Inserting categories into the 'category' table
        DB::table('category')->insert([

                [
                    'Name' => 'Fruits & Vegetables',
                    'Description' => 'Fresh fruits and vegetables for daily consumption.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'Name' => 'Dairy & Eggs',
                    'Description' => 'Milk, cheese, eggs, and other dairy products.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'Name' => 'Bakery & Bread',
                    'Description' => 'Fresh bread, rolls, and other baked goods.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'Name' => 'Meat & Seafood',
                    'Description' => 'Fresh and frozen meat, poultry, and seafood items.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'Name' => 'Pantry Essentials',
                    'Description' => 'Staples like rice, pasta, canned goods, and spices.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

            // Add more categories as needed
        ]);
    }
}
