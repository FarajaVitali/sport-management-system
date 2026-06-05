<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sport;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Explicitly defining default tournament options
        $sports = ['football', 'basketball', 'volleyball', 'netball'];

        foreach ($sports as $sport) {
            Sport::firstOrCreate(['name' => $sport]);
        }
    }
}