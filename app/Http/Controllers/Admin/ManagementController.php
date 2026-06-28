<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Team; 
use App\Models\Sport;
use App\Models\Fixture;
use App\Models\User; 
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function index()
    {
        $colleges = College::all();
        $sports = Sport::all();
        
        $teams = Team::with(['college', 'sport', 'coachProfile.user'])->get();
        $coaches = User::where('role', 'coach')->get();

        return view('admin.management', compact('colleges', 'sports', 'teams', 'coaches'));
    }

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
        ]);

        Team::create([
            'name'       => $validated['name'],
            'college_id' => $validated['college_id'],
            'sport_id'   => $validated['sport_id'],
        ]);

        return redirect()->back()->with('success', 'New Team squad parameters deployed successfully! Coaches can now link to this roster.');
    }

    public function viewCoaches()
    {
        $coaches = User::where('role', 'coach')
            ->with(['coachProfile.team.college'])
            ->get();

        return view('admin.coaches', compact('coaches'));
    }

    public function generateFixtures()
    {
        Fixture::truncate();

        $sports = Sport::has('teams')->get();

        $sportConfigurations = [
            'football'   => ['venue' => 'Main Stadium Field', 'time' => '16:00:00'],
            'basketball' => ['venue' => 'Inside Sports Complex', 'time' => '10:00:00'],
            'volleyball' => ['venue' => 'Outer Court A', 'time' => '08:30:00'],
            'netball'    => ['venue' => 'Outer Court B', 'time' => '14:00:00'],
        ];

        foreach ($sports as $sport) {
            $sportName = trim(strtolower($sport->name));
            
            $assignedVenue = $sportConfigurations[$sportName]['venue'] ?? 'General Campus Arena';
            $assignedTime  = $sportConfigurations[$sportName]['time'] ?? '15:00:00';

            $teams = Team::where('sport_id', $sport->id)->pluck('id')->toArray();
            
            if (count($teams) % 2 !== 0) {
                $teams[] = null; 
            }

            $totalTeams = count($teams);
            $totalRounds = $totalTeams - 1;
            $matchesPerRound = $totalTeams / 2;

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
                            'venue'        => $assignedVenue,
                            'status'       => 'scheduled'
                        ]);
                    }
                }

                $firstTeam = array_shift($teams);
                array_push($teams, array_pop($teams));
                array_unshift($teams, $firstTeam);
            }
        }

        return redirect()->back()->with('success', 'Full tournament match schedules compiled with explicit venues and times automatically!');
    }

    /**
     * Start the match and start the clock.
     */
public function startMatch($id)
{
    $fixture = Fixture::findOrFail($id);
    
    // Log the update attempt
    \Log::info('Updating fixture: ' . $id);
    
    $fixture->update([
        'status' => 'live',
        'started_at' => now(), // If this is still null in DB, the issue is database-level
        'home_score' => 0,
        'away_score' => 0,
    ]);
    
    return redirect()->back();
}

    /**
     * Increment the score dynamically via AJAX.
     */
    public function addGoal(Request $request, $id)
{
    $fixture = Fixture::findOrFail($id);
    $team = $request->input('team'); 

    if ($team === 'home') {
        $fixture->increment('home_score');
    } else {
        $fixture->increment('away_score');
    }

    return response()->json([
        'home_score' => $fixture->home_score,
        'away_score' => $fixture->away_score,
    ]);
}

    /**
     * End the match and lock the final score.
     */
    public function endMatch($id)
    {
        $fixture = Fixture::findOrFail($id);
        $fixture->update([
            'status' => 'completed'
        ]);
        
        return redirect()->back();
    }

    /**
     * View all fixtures list.
     */
    public function viewFixtures()
    {
        $fixtures = Fixture::with(['homeTeam', 'awayTeam'])->orderBy('match_date', 'asc')->get();
        return view('admin.fixtures', compact('fixtures'));
    }

    /**
     * Display the Live Match Control Panel.
     */
   public function showLivePanel($id)
{
    $fixture = Fixture::with(['homeTeam', 'awayTeam'])->findOrFail($id);
    
    // TEMPORARY DEBUG: This will show you exactly what data exists
    //dd($fixture->toArray()); 
    
    return view('admin.live_match', compact('fixture'));
}
}