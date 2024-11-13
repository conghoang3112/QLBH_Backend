<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\development\DevelopmentSeeder;
use Database\Seeders\staging\StagingSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        switch (config('app.env')){
            case 'staging':
                $this->call([StagingSeeder::class]);
                break;
            default:
                $this->call([DevelopmentSeeder::class]);
        }
    }
}
