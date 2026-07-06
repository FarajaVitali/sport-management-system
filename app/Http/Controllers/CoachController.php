<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;    
use App\Models\College; 
use App\Models\Fixture; 
use App\Models\CoachProfile;
use App\Models\PlayerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CoachController extends Controller
{
    /**
     * Show the main coach onboarding registration setup form.
     */
    public function showCoachForm(): View
    {
        // Load colleges to populate the primary dropdown
        $colleges = College::all();

        return view('coach.coach_form', compact('colleges'));
    }

    /**
     * Handle the form submission and save the coach profile parameters.
     */
    public function storeInfo(Request $request): RedirectResponse
    {
        // Validate the incoming inputs securely
        $validated = $request->validate([
            'college_id'   => 'required|exists:colleges,id',
            'team_id'      => 'required|exists:teams,id',
            'phone_number' => 'required|string|max:20',
        ]);

        // Securely perform database transaction operations
        DB::transaction(function () use ($validated) {
            $user = Auth::user();

            $user->coachProfile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'college_id'   => $validated['college_id'],
                    'team_id'      => $validated['team_id'],
                    'phone_number' => $validated['phone_number'],
                ]
            );
        });

        return redirect()
            ->route('coach.dashboard')
            ->with('success', 'Your Coach Profile has been set up successfully!');
    }

    /**
     * View all players belonging to the coach's team.
     */
    public function viewPlayers()
    {
        // 1. Get the currently logged-in coach
        $coach = Auth::user();
        
        // 2. Initialize variables so they are never undefined
        $team = null;
        $players = collect(); // Returns an empty Laravel collection by default

        // 3. Check if the coach has a profile and an assigned team
        if ($coach->coachProfile && $coach->coachProfile->team) {
            
            $team = $coach->coachProfile->team;
            
            // 4. Fetch all players assigned to this specific team
            $players = User::where('role', 'player')
                ->whereHas('playerProfile', function($query) use ($team) {
                    $query->where('team', $team->name); 
                })
                ->with('playerProfile')
                ->get();
        }

        // 5. Pass BOTH variables to your new view
        return view('coach.team_players', compact('team', 'players'));
    }

    /**
     * View all match schedule fixtures involving the coach's team.
     */
    public function viewFixtures(): View
    {
        $teamId = Auth::user()->coachProfile->team_id;

        // Updated to use the correct model and removed 'sport' relationship
        $fixtures = Fixture::with(['homeTeam', 'awayTeam'])
            ->where('home_team_id', $teamId)
            ->orWhere('away_team_id', $teamId)
            ->orderBy('match_date', 'asc')
            ->get();

        return view('coach.match_fixtures', compact('fixtures'));
    }

    /**
     * Display the Coach's Profile Screen card.
     */
    public function viewProfile(): View
    {
        $user = Auth::user()->load('coachProfile.team.college');
        return view('coach.coach_profile', compact('user'));
    }

    /**
     * Show Edit Form view layout.
     */
    public function editProfile(): View
    {
        $user = Auth::user();
        return view('coach.profile_edit', compact('user'));
    }

    /**
     * Handle updating security credentials and profile info.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'fname'    => 'required|string|max:255',
            'lname'    => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->fname = $request->fname;
        $user->lname = $request->lname; // Fixed: was $user->lname
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()
            ->route('coach.dashboard')
            ->with('success', 'Profile configuration settings updated successfully!');
    }

    /**
     * Update a player's tactical position, stats, and physical status.
     */
    public function updatePlayerTactics(Request $request, $id)
    {
        $request->validate([
            'position' => 'required|string|max:50',
            'jersey_number' => 'nullable|integer|min:1|max:99',
            'physical_status' => 'required|in:Fit,Injured,Benched,Suspended',
            'goals' => 'required|integer|min:0',
            'assists' => 'required|integer|min:0',
            'yellow_cards' => 'required|integer|min:0',
            'red_cards' => 'required|integer|min:0',
        ]);

        // Using the imported PlayerProfile model
        $profile = PlayerProfile::where('user_id', $id)->firstOrFail();

        $profile->update([
            'position' => $request->position,
            'jersey_number' => $request->jersey_number,
            'physical_status' => $request->physical_status,
            'goals' => $request->goals,
            'assists' => $request->assists,
            'yellow_cards' => $request->yellow_cards,
            'red_cards' => $request->red_cards,
        ]);

        return redirect()->back()->with('success', 'Player profile and statistics updated successfully.');
    }
}