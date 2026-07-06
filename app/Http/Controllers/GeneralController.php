<?php
namespace App\Http\Controllers;

use App\Models\Sport;
use App\Models\Fixture;
use App\Models\Team;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function showStandings()
    {
        // Fetch completed fixtures (Results)
        // Changed 'date' to 'created_at' to prevent the SQL error
        $results = Fixture::where('status', 'completed')
                    ->orderBy('created_at', 'desc')
                    ->get();

        // Fetch teams ordered by points (Standings)
        $standings = Team::orderBy('points', 'desc')->get();
        
        return view('player.results_standing', compact('results', 'standings'));
    }
}