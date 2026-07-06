<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\College; 
use App\Models\Team;    
use App\Models\Sport;
use App\Models\Fixture;
use App\Models\Position; // Added this import so the position method works
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
     * UPDATED: Includes 'sport' relationship for frontend logic.
     */
    public function getTeamsByCollege($collegeId)
    {
        $teams = Team::with('sport')->where('college_id', $collegeId)->get();
        return response()->json($teams);
    }
   
    /**
     * Display the authenticated player's system dashboard.
     */
public function showPlayerDashboard()
{
    // 1. Get the current user
    $user = auth()->user();

    // 2. SECURITY CHECK: Only allow players
    if ($user->role !== 'player') {
        return redirect()->route('login')->with('error', 'Unauthorized access.');
    }

    // 3. Pass the user to the view
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
     * Display the fixture list ordered by date for the live dashboard.
     */
    public function viewFixtures()
    {
        $upcoming = Fixture::with(['homeTeam', 'awayTeam'])
            ->whereIn('status', ['scheduled', 'live'])
            ->orderBy('match_date', 'asc')
            ->get();

        $results = Fixture::with(['homeTeam', 'awayTeam'])
            ->where('status', 'completed')
            ->orderBy('match_date', 'desc')
            ->get();

        return view('player.fixtures', compact('upcoming', 'results'));
    }

    /**
     * Update or create the player's profile information matrix.
     */
    /**
 * Update or create the player's profile information matrix.
 */
public function updateInfo(Request $request): RedirectResponse
{
    // 1. Validation: Matches your form fields exactly
    $validated = $request->validate([
        'college_id' => 'required|exists:colleges,id',
        'team'       => 'required|string|max:255',
    ]);

    // 2. Database transaction
    DB::transaction(function () use ($request, $validated) {
        $user = $request->user();

        $user->playerProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'college_id' => $validated['college_id'],
                'team'       => $validated['team'],
                // 'position' has been removed
            ]
        );
    });

    return redirect()
        ->route('player.player_dashboard')
        ->with('success', 'Player information updated!');
}

    /**
     * Fetch positions for the dynamic dropdown.
     */
    public function getPositionsBySport(Request $request)
    {
        $sportName = $request->query('sport');
        return response()->json(Position::where('sport_name', $sportName)->get());
    }

    /**
     * Store a newly created fixture with strict validation safety.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Structural payload validations
        $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'match_date'   => 'required|date',
            'venue'        => 'nullable|string',
        ]);

        // 2. Resolve target team instances
        $homeTeam = Team::find($request->home_team_id);
        $awayTeam = Team::find($request->away_team_id);

        // 3. THE GENDER BUG FIX: Block matchmaking across different divisions
        if ($homeTeam->gender !== $awayTeam->gender) {
            return back()
                ->withInput()
                ->withErrors(['matchmaking_error' => 'Invalid Matchup: A ' . ucfirst($homeTeam->gender) . '\'s team cannot play against a ' . ucfirst($awayTeam->gender) . '\'s team.']);
        }
        
        // 4. SPORT SANITY CHECK: Ensure teams are registered under the same sport profile
        if ($homeTeam->sport_id !== $awayTeam->sport_id) {
            return back()
                ->withInput()
                ->withErrors(['matchmaking_error' => 'Invalid Matchup: Selected teams belong to different sports.']);
        }

        // 5. Instantiation layer execution
        Fixture::create([
            'home_team_id'   => $request->home_team_id,
            'away_team_id'   => $request->away_team_id,
            'match_date'     => $request->match_date,
            'venue'          => $request->venue,
            'status'         => 'scheduled',
            'sport_category' => $homeTeam->sport->name ?? 'Other', 
        ]);

        return redirect()
            ->route('fixtures.index')
            ->with('success', 'Fixture created safely and successfully!');
    }
}