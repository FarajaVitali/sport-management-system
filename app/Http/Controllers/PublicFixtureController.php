<?php

namespace App\Http\Controllers;

use App\Models\Fixture;

class PublicFixtureController extends Controller
{
    public function index()
    {
        $fixtures = Fixture::with(['homeTeam', 'awayTeam'])
            ->orderBy('match_date', 'desc')
            ->get();

        return view('fixtures', compact('fixtures'));
    }
}