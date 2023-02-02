<?php 

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        if (!Role::exists(Role::ADMIN)) {
            Role::create([
                'id' => Role::ADMIN,
                'name' => 'Admin'
            ]);
        }

        if (!Role::exists(Role::USER)) {
            Role::create([
                'id' => Role::USER,
                'name' => 'User'
            ]);
        }
    }
}
