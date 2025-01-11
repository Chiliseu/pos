<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        UserRole::create(['RoleName' => 'Staff']);
        UserRole::create(['RoleName' => 'Admin']);
    }
}
