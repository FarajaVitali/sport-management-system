<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Sport;
use Illuminate\Http\Request;

class PublicRuleController extends Controller
{
    public function index()
    {
        // 1. Fetch all sports (to list the tabs)
        $sports = Sport::all();
        
        // 2. Fetch all rules (these are the ones the Admin added in the database)
        $rules = Rule::all();
        
        // 3. Return the correct file path (rules.index points to resources/views/rules/index.blade.php)
        return view('rules', compact('sports', 'rules'));
    }
}