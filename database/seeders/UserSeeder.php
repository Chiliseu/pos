<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        // First user with UserRoleID 1
        User::create([
            //'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('SecurePassword2025!'), // Fixed NIST-compliant password
            'UserRoleID' => 1,
            'Firstname' => 'John',
            'Lastname' => 'Doe',
            'MiddleInitial' => 'A',
            'Suffix' => '',
            'ContactNo' => '1234567890',
            'UniqueIdentifier' => strtoupper('USR-' . Str::random(6)),
        ]);

        // Second user with UserRoleID 2
        User::create([
            //'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'password' => Hash::make('MySuperStrongPass15@'),
            'UserRoleID' => 2,
            'Firstname' => 'Jane',
            'Lastname' => 'Smith',
            'MiddleInitial' => 'B',
            'Suffix' => 'Jr',
            'ContactNo' => '0987654321',
            'UniqueIdentifier' => strtoupper('USR-' . Str::random(6)),
        ]);
    }
}
