<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use App\Models\User;
use App\Models\College;
use App\Models\Team;
use App\Models\Sport;
use App\Models\CoachProfile;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function index()
    {
        $colleges = College::all();
        $teams = Team::with(['college', 'sport', 'coachProfile.user'])->get();
        $sports = Sport::all();
        $coaches = User::where('role', 'coach')->get();

        return view('admin.management', compact('colleges', 'teams', 'sports', 'coaches'));
    }

    public function storeCollege(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        College::create($request->only(['name']));

        return back()->with('success', 'College added successfully!');
    }

    public function storeTeam(Request $request)
    {
        $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'sport_id'   => 'required|exists:sports,id',
            'gender'     => 'required|in:men,women',
            'name'       => 'required|string|max:255',
            'coach_id'   => 'nullable|exists:users,id',
        ]);

        $coachProfileId = null;

        if ($request->filled('coach_id')) {
            // The dropdown lists Users (role=coach), but Team links to a CoachProfile,
            // so find (or create) the coach_profiles row tied to that user.
            $coachProfile = CoachProfile::firstOrCreate(['user_id' => $request->coach_id]);
            $coachProfileId = $coachProfile->id;
        }

        Team::create([
            'name'             => $request->name,
            'college_id'       => $request->college_id,
            'sport_id'         => $request->sport_id,
            'gender'           => $request->gender,
            'coach_profile_id' => $coachProfileId,
        ]);

        return back()->with('success', 'Team assembled successfully!');
    }

    public function generateFixtures(Request $request)
    {
        // Wipe the existing schedule first, matching the frontend confirm() warning
        // that regenerating fixtures will replace whatever is currently scheduled.
        Fixture::truncate();

        $teams = Team::all();

        // Group strictly by sport AND gender, so men's/women's teams and teams from
        // different sports are never paired against each other.
        $groups = $teams->groupBy(function ($team) {
            return $team->sport_id . '|' . $team->gender;
        });

        foreach ($groups as $group) {
            // Shuffle so pairings aren't always in the same DB order, then split into
            // non-overlapping pairs. Because chunk(2) consumes teams in order without
            // repeating any of them, no team can end up assigned to more than one
            // fixture in a single generation run.
            $pool = $group->shuffle()->values();

            foreach ($pool->chunk(2) as $pair) {
                // chunk() keeps each item's original key (e.g. the second chunk might
                // be keyed [2 => ..., 3 => ...] instead of [0 => ..., 1 => ...]), so
                // re-index with values() before accessing by numeric position.
                $pair = $pair->values();

                if ($pair->count() < 2) {
                    // Odd team out in this sport/gender group - no opponent left,
                    // so it gets a bye (no fixture) rather than being reused.
                    continue;
                }

                Fixture::create([
                    'home_team_id' => $pair[0]->id,
                    'away_team_id' => $pair[1]->id,
                    'sport_id'     => $pair[0]->sport_id,
                    'status'       => 'scheduled',
                ]);
            }
        }

        return back()->with('success', 'Fixtures generated successfully!');
    }

    public function viewFixtures()
    {
        $fixtures = Fixture::with(['homeTeam', 'awayTeam', 'referee'])->get();
        $referees = User::where('role', 'referee')->get();

        return view('admin.fixtures', compact('fixtures', 'referees'));
    }

    public function assignReferee(Request $request, $id)
    {
        $request->validate([
            'referee_id' => 'required|exists:users,id'
        ]);
        $fixture = Fixture::findOrFail($id);
        $fixture->referee_id = $request->referee_id;
        $fixture->save();

        return back()->with('success', 'Referee assigned successfully!');
    }

    public function showLivePanel($id)
    {
        $fixture = Fixture::with(['homeTeam', 'awayTeam', 'referee'])->findOrFail($id);

        // Change 'admin.live_control' to match your actual Blade view name
        return view('admin.live_match', compact('fixture'));
    }
    

    public function viewCoaches()
    {
        $coaches = User::where('role', 'coach')->get();

        return view('admin.coaches', compact('coaches'));
    }
    public function endMatch($id)
{
    $fixture = \App\Models\Fixture::findOrFail($id);
    
    // Prevent double-counting if a referee or admin accidentally clicks "End" twice
    if ($fixture->status === 'completed') {
        return redirect()->back()->with('error', 'This match is already completed and points are distributed.');
    }

    // 1. Mark fixture as completed
    $fixture->status = 'completed';
    $fixture->save();

    // 2. Fetch the actual Team models
    $homeTeam = $fixture->homeTeam;
    $awayTeam = $fixture->awayTeam;

    if ($homeTeam && $awayTeam) {
        // 3. Increment Matches Played
        $homeTeam->played += 1;
        $awayTeam->played += 1;

        // 4. Update Goals For (GF) and Goals Against (GA)
        $homeTeam->goals_for += $fixture->home_score;
        $homeTeam->goals_against += $fixture->away_score;
        
        $awayTeam->goals_for += $fixture->away_score;
        $awayTeam->goals_against += $fixture->home_score;

        // 5. Distribute Points and Win/Loss/Draw Stats
        if ($fixture->home_score > $fixture->away_score) {
            // Home Team Wins
            $homeTeam->won += 1;
            $homeTeam->points += 3;
            
            $awayTeam->lost += 1;
        } elseif ($fixture->home_score < $fixture->away_score) {
            // Away Team Wins
            $awayTeam->won += 1;
            $awayTeam->points += 3;
            
            $homeTeam->lost += 1;
        } else {
            // Match is a Draw
            $homeTeam->drawn += 1;
            $homeTeam->points += 1;
            
            $awayTeam->drawn += 1;
            $awayTeam->points += 1;
        }

        // 6. Save the updated team statistics to the database
        $homeTeam->save();
        $awayTeam->save();
    }

    return redirect()->back()->with('success', 'Match finished! Points and standings updated.');
}
}