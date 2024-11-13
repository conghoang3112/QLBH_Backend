<?php

namespace Database\Seeders\development;

use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('ALTER TABLE users NOCHECK CONSTRAINT ALL');
        DB::statement('ALTER TABLE roles NOCHECK CONSTRAINT ALL');

        // Xóa tất cả dữ liệu trong bảng (delete thay vì truncate)
        DB::table('roles')->delete();
        DB::table('users')->delete();

        DB::statement('ALTER TABLE users CHECK CONSTRAINT ALL');
        DB::statement('ALTER TABLE roles CHECK CONSTRAINT ALL');

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
