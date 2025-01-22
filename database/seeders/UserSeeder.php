<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // First user with UserRoleID 1
        User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password'),
            'UserRoleID' => 1,
            'Firstname' => 'John',
            'Lastname' => 'Doe',
            'MiddleInitial' => 'A',
            'Suffix' => '',
            'ContactNo' => '1234567890',
            'UniqueIdentifier' => $this->generateUniqueIdentifier(),
        ]);

        // Second user with UserRoleID 2
        User::create([
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'password' => Hash::make('password'),
            'UserRoleID' => 2,
            'Firstname' => 'Jane',
            'Lastname' => 'Smith',
            'MiddleInitial' => 'B',
            'Suffix' => 'Jr',
            'ContactNo' => '0987654321',
            'UniqueIdentifier' => $this->generateUniqueIdentifier(),
        ]);
    }

    private function generateUniqueIdentifier()
    {
        $randomLetter = chr(rand(65, 90)); // Generate a random uppercase letter
        $randomNumber = rand(1000, 9999); // Generate a random number
        return 'USR-' . $randomLetter . $randomNumber;
    }
}
