<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'Football'   => ['Goalkeeper', 'Defender', 'Midfielder', 'Striker'],
            'Basketball' => ['Point Guard', 'Shooting Guard', 'Small Forward', 'Power Forward', 'Center'],
            'Volleyball' => ['Setter', 'Libero', 'Middle Blocker', 'Outside Hitter'],
            'Netball'    => ['Goal Shooter', 'Goal Attack', 'Wing Attack', 'Centre', 'Wing Defence', 'Goal Defence', 'Goal Keeper'],
        ];

        foreach ($data as $sport => $positions) {
            foreach ($positions as $position) {
                DB::table('positions')->updateOrInsert(
                    ['sport_name' => $sport, 'name' => $position]
                );
            }
        }
    }
}