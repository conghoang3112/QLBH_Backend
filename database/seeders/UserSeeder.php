<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();

        if ($adminRole) {
            User::create([
                'role_id' => $adminRole->id,
                'username' => 'Admin',
                'fullName' => 'Admin',
                'password' => Hash::make(md5('password')),  
                'passwordDesktop' => '',  
            ]);
        } else {
            echo "Role 'admin' not found. Make sure RoleSeeder has been run.\n";
        }
    }
}
