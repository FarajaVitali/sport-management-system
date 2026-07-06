<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use App\Models\User; // Make sure to import User model
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    // 1. Update your existing viewFixtures method
    public function viewFixtures()
    {
        // Fetch fixtures and eager load relationships to prevent N+1 issues
        $fixtures = Fixture::with(['homeTeam', 'awayTeam', 'referee'])->get(); 
        
        // Fetch users who have the role of 'referee'
        $referees = User::where('role', 'referee')->get(); 
        
        return view('admin.fixtures', compact('fixtures', 'referees'));
    }

    // 2. Add the assignment method (if you haven't already)
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
    
    // ... your other methods ...
}