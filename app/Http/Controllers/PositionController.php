<?php

namespace App\Http\Controllers;

use App\Models\Position; // Import your Model
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function getBySport(Request $request) 
    {
        // Fetch positions where the sport_name matches the request parameter
        return Position::where('sport_name', $request->sport)->get();
    }
}