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
        $sports = Sport::all();

        $standings = Team::all()->groupBy(['sport_id', 'gender']);

        $results = Fixture::with(['homeTeam', 'awayTeam'])
            ->where('status', 'completed')
            ->latest('match_date')
            ->get()
            ->groupBy([
                fn ($fixture) => $fixture->homeTeam->sport_id ?? 0,
                fn ($fixture) => $fixture->homeTeam->gender ?? 'men',
            ]);

        // CHANGED: Point this to a new public view instead of the player view
        return view('public.standings', compact('sports', 'standings', 'results'));
    }
}