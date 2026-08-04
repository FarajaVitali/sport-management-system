<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use Illuminate\Http\Request;

class PublicFixtureController extends Controller
{
    public function index()
    {
        // Fetch all fixtures with their teams
        $fixtures = Fixture::with(['homeTeam', 'awayTeam'])->orderBy('match_date', 'asc')->get();
        
        // Return a strictly PUBLIC view
        return view('public.fixtures', compact('fixtures'));
    }
}