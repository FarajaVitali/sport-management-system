<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call your custom sport compiler seeder here
        $this->call([
            SportSeeder::class,
        ]);
        
        // You can add other seeders here later (e.g., default admin user account)
    }
}