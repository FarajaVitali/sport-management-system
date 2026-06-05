<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\College; 
use App\Models\Team;    
use App\Models\Sport;
use App\Models\Fixture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PlayerController extends Controller
{
    /**
     * Show the main player registration form setup layout.
     */
    public function showPlayerForm(): View
    {
        $colleges = College::all();

        return view('player.player', compact('colleges'));
    }

    /**
     * Fetch teams dynamically matching the selected college ID for JavaScript dropdowns.
     */
    public function getTeamsByCollege($collegeId)
    {
        // Fetch only the teams that match the selected college_id
        $teams = Team::where('college_id', $collegeId)->get();

        // Send the data back to your JavaScript as a clean JSON response
        return response()->json($teams);
    }
   
    /**
     * Display the authenticated player's system dashboard.
     */
    public function showPlayerDashboard(): View
    {
        $user = Auth::user();
        
        return view('player.player_dashboard', compact('user'));
    }
    
    /**
     * Show the primary profile details setup dashboard card module.
     */
    public function showPlayerProfile(): View
    {
        $user = Auth::user();
        
        return view('player.player_profile', compact('user'));
    }

    /**
     * Display the comprehensive league match calendar to players split cleanly by sport.
     */
    public function viewFixtures()
    {
        // Fetch matches, eager-load relationships, and group them by Sport first, then by Round
        $fixturesBySport = Fixture::with(['homeTeam.sport', 'awayTeam'])
            ->get()
            ->groupBy(function ($fixture) {
                // Safely group by the home team's sport name
                return $fixture->homeTeam->sport->name ?? 'General / Other';
            })
            ->map(function ($sportMatches) {
                // Within each sport, group the matches by their round number
                return $sportMatches->groupBy('round_number');
            });

        return view('player.fixtures', compact('fixturesBySport'));
    }

    /**
     * Update or create the player's profile information matrix.
     */
    public function updateInfo(Request $request): RedirectResponse
    {
        // 1. Validate the incoming data securely including college_id verification
        $validated = $request->validate([
            'college_id'    => 'required|exists:colleges,id',
            'team'          => 'required|string|max:255',
            'jersey_number' => 'required|integer|min:0|max:99',
            'position'      => 'required|string|max:100',
        ]);

        // 2. Perform safe database transaction operations to populate attributes
        DB::transaction(function () use ($request, $validated) {
            $user = $request->user();

            $user->playerProfile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'college_id'    => $validated['college_id'],
                    'team'          => $validated['team'],
                    'jersey_number' => $validated['jersey_number'],
                    'position'      => $validated['position'],
                ]
            );
        });

        return redirect()
            ->route('player.player_dashboard')
            ->with('success', 'Player information has been updated successfully!');
    }
}