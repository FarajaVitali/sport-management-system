<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    public function run()
    {
        // Define your sports and positions
        $data = [
            'Football' => ['Goalkeeper', 'Defender', 'Midfielder', 'Striker'],
            'Basketball' => ['Point Guard', 'Shooting Guard', 'Small Forward', 'Power Forward', 'Center'],
            'Volleyball' => ['Setter', 'Libero', 'Middle Blocker', 'Outside Hitter'],
        ];

        foreach ($data as $sport => $positions) {
            foreach ($positions as $position) {
                DB::table('positions')->insert([
                    'sport_name' => $sport, // Ensure your table has this column
                    'name' => $position,
                ]);
            }
        }
    }
}