<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    public function index() {
    $rules = \App\Models\Rule::all();
    return view('admin.rules', compact('rules'));
}

public function store(Request $request) {
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
    ]);
    \App\Models\Rule::create($validated);
    return back()->with('success', 'Rule added successfully!');
}
}
