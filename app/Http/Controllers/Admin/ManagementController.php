<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Team; 
use App\Models\Sport;
use App\Models\Fixture;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function index()
    {
        $colleges = College::all();
        $sports = Sport::all();
        $teams = Team::with(['college', 'sport'])->get();

        return view('admin.management', compact('colleges', 'sports', 'teams'));
    }

    /**
     * Register a new Institution / College.
     */
    public function storeCollege(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colleges,name',
        ]);

        College::create($validated);

        return redirect()->back()->with('success', 'New Institution / College logged successfully!');
    }

    public function storeTeam(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255|unique:teams,name',
            'college_id' => 'required|exists:colleges,id',
            'sport_id'   => 'required|exists:sports,id',
            'coach_name' => 'nullable|string|max:255',
        ]);

        Team::create([
            'name'       => $validated['name'],
            'college_id' => $validated['college_id'],
            'sport_id'   => $validated['sport_id'],
            'coach_name' => $validated['coach_name'] ?? 'TBD',
        ]);

        return redirect()->back()->with('success', 'New Team squad parameters deployed successfully!');
    }

    /**
     * Automatically compiles tournament match matrices using a Sport-Filtered Round Robin formula.
     */
   public function generateFixtures()
{
    // 1. Clear existing fixtures for a clean reset
    Fixture::truncate();

    // 2. Fetch all unique sport categories with teams registered
    $sports = Sport::has('teams')->get();

    // 3. Define structural configuration parameters matching database values
    $sportConfigurations = [
        'football'   => ['venue' => 'Main Stadium Field', 'time' => '16:00:00'],
        'basketball' => ['venue' => 'Inside Sports Complex', 'time' => '10:00:00'],
        'volleyball' => ['venue' => 'Outer Court A', 'time' => '08:30:00'],
        'netball'    => ['venue' => 'Outer Court B', 'time' => '14:00:00'],
    ];

    // 4. Run the generator independently for each sport type group
    foreach ($sports as $sport) {
        // FIX: Strip whitespace and force lowercase to guarantee a match
        $sportName = trim(strtolower($sport->name));
        
        // Safe fallbacks if the name doesn't match the configuration matrix arrays exactly
        $assignedVenue = $sportConfigurations[$sportName]['venue'] ?? 'General Campus Arena';
        $assignedTime  = $sportConfigurations[$sportName]['time'] ?? '15:00:00';

        // Pull only the team IDs belonging to this specific sport
        $teams = Team::where('sport_id', $sport->id)->pluck('id')->toArray();
        
        if (count($teams) % 2 !== 0) {
            $teams[] = null; // Dummy placeholder for resting "Bye" week
        }

        $totalTeams = count($teams);
        $totalRounds = $totalTeams - 1;
        $matchesPerRound = $totalTeams / 2;

        // Circle Rotation Matrix Formula Execution
        for ($round = 0; $round < $totalRounds; $round++) {
            
            $matchDay = now()->addDays($round * 7)->format('Y-m-d');
            $completeMatchTimestamp = $matchDay . ' ' . $assignedTime;

            for ($match = 0; $match < $matchesPerRound; $match++) {
                $home = $teams[$match];
                $away = $teams[$totalTeams - 1 - $match];

                if ($home !== null && $away !== null) {
                    Fixture::create([
                        'home_team_id' => $home,
                        'away_team_id' => $away,
                        'round_number' => $round + 1,
                        'match_date'   => $completeMatchTimestamp,
                        'venue'        => $assignedVenue, // Inserts the clean matched string
                        'status'       => 'scheduled'
                    ]);
                }
            }

            // Standard Round Robin matrix rotation logic
            $firstTeam = array_shift($teams);
            array_push($teams, array_pop($teams));
            array_unshift($teams, $firstTeam);
        }
    }

    return redirect()->back()->with('success', 'Full tournament match schedules compiled with explicit venues and times automatically!');
}
} 