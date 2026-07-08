<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use App\Models\User;
use App\Models\College;
use App\Models\Team;
use App\Models\Sport;      // <-- needed for $sports
use App\Models\CoachProfile; // <-- adjust to whatever your coach model/relation is
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function index()
    {
        $colleges = College::all();
        $teams = Team::with(['college', 'sport', 'coachProfile.user'])->get();
        $sports = Sport::all();
        $coaches = User::where('role', 'coach')->get(); // adjust condition to match your schema

        return view('admin.management', compact('colleges', 'teams', 'sports', 'coaches'));
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
    public function viewCoaches()
{
    $coaches = User::where('role', 'coach')->get(); // adjust condition/relation to match your schema

    return view('admin.coaches', compact('coaches'));
}
}