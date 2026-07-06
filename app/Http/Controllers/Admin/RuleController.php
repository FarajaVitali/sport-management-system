<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rule;
use App\Models\Sport;

class RuleController extends Controller
{
    /**
     * Display a listing of the rules and sports.
     */
    public function index()
    {
        $sports = Sport::all(); // Fetch all seeded sports from the database
        $rules = Rule::all();
        
        // Pass both variables to the view
        return view('admin.rules', compact('sports', 'rules'));
    }

    /**
     * Store a newly created rule in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sport' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
        ]);
        
        Rule::create($validated);
        
        return back()->with('success', 'Rule added successfully!');
    }
}