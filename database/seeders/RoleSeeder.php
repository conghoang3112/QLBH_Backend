<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['slug' => 'admin', 'name' => 'Admin']);
        Role::create(['slug' => 'giam_sat', 'name' => 'Giám sát']);
        Role::create(['slug' => 'ke_hoach', 'name' => 'Kế hoạch']);
    }
}
