<?php

namespace App\Http\Controllers;

use App\Models\Team;    
use App\Models\College; 
use App\Models\Fixture; // Changed from MatchFixture to match your actual model file
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
    public function viewPlayers(): View
    {
        $coach = Auth::user()->coachProfile;
        
        // Fetch players assigned to the exact same team as the coach using the relationship layer
        $players = PlayerProfile::with('user')
            ->whereHas('team', function ($query) use ($coach) {
                $query->where('id', $coach->team_id);
            })
            ->get();

        return view('coach.team_players', compact('players'));
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
        $user->lname = $user->lname;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()
            ->route('coach.dashboard')
            ->with('success', 'Profile configuration settings updated successfully!');
    }
}