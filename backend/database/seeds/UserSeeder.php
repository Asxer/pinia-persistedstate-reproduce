<?php 

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $adminPassword = '123'; // It is hardcoded to simplify reproducing script

        $admin = factory(User::class)->create([
            'email' => 'admin@admin.com',
            'role_id' => Role::ADMIN,
            'password' => bcrypt($adminPassword)
        ]);

        echo "  \e[0;31;42mAdmin's credentials login: {$admin->email}; password: {$adminPassword}. Keep it in secret\e[0m\n";

        factory(User::class)->create([
            'role_id' => Role::USER
        ]);
    }
}
