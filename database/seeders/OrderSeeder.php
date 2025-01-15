<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run()
    {
        DB::table('orders')->insert([
        [
            'OrderDate' => '2024-12-01',
            'Subtotal' => 50.75,
            'Total' => 60.00,
        ],
        [
            'OrderDate' => '2024-12-10',
            'Subtotal' => 100.50,
            'Total' => 110.00,
        ],
        [
            'OrderDate' => '2024-12-15',
            'Subtotal' => 75.25,
            'Total' => 80.00,
        ],
        [
            'OrderDate' => '2024-12-20',
            'Subtotal' => 85.00,
            'Total' => 95.00,
        ],
        [
            'OrderDate' => '2024-12-25',
            'Subtotal' => 120.00,
            'Total' => 130.00,
        ],
        [
            'OrderDate' => '2024-12-30',
            'Subtotal' => 95.75,
            'Total' => 105.00,
        ],
        ]);

    }
}
