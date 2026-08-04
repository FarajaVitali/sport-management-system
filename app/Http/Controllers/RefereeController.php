<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RefereeController extends Controller
{
    /**
     * Display all fixtures assigned to the authenticated referee.
     */
    public function dashboard(): View
    {
        $referee = Auth::user();
        
        $assignedFixtures = Fixture::with(['homeTeam', 'awayTeam'])
            ->where('referee_id', $referee->id)
            ->orderBy('match_date', 'asc')
            ->get();

        return view('referee.dashboard', compact('assignedFixtures'));
    }

    /**
     * Securely update the live score or match final results.
     */
    public function updateFixture(Request $request, $id): RedirectResponse
    {
        $fixture = Fixture::findOrFail($id);

        // Security Check: Verify this referee is actually assigned to this match
        if ($fixture->referee_id !== Auth::id()) {
            return back()->withErrors(['auth_error' => 'Unauthorized: You are not assigned to officiate this match.']);
        }

        $validated = $request->validate([
            'home_score' => 'required|integer|min:0',
            'away_score' => 'required|integer|min:0',
            'status'     => 'required|in:scheduled,live,completed',
        ]);

        $fixture->update([
            'home_score' => $validated['home_score'],
            'away_score' => $validated['away_score'],
            'status'     => $validated['status'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Match score matrix updated successfully!');
    }

    public function startMatch(Request $request, $id)
{
    $fixture = \App\Models\Fixture::findOrFail($id);

    // Perform your logic
    $fixture->update([
        'is_live' => true,
        'live_status' => 'First Half'
    ]);

    // Redirect back regardless of whether the request was GET or POST
    return redirect()->back()->with('success', 'Match has been started!');
}

public function updateScore(Request $request, $id)
{
    $fixture = \App\Models\Fixture::findOrFail($id);

    if ($fixture->referee_id !== Auth::id()) {
        return back()->withErrors(['auth_error' => 'Unauthorized: You are not assigned to officiate this match.']);
    }

    if ($request->action === 'start_match') {
        $fixture->update([
            'is_live' => true,
            'status' => 'First Half',
        ]);
        return redirect()->back()->with('success', 'Match has been started!');
    }

    $fixture->update([
        'home_score' => $request->home_team_score,
        'away_score' => $request->away_team_score,
        'is_live' => $request->has('is_live'),
        'status' => $request->live_status,
    ]);

    return redirect()->back()->with('success', 'Match data updated successfully!');
}
}