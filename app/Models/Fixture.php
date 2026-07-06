<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fixture extends Model
{
    protected $fillable = [
    'home_team_id', 
    'away_team_id', 
    'match_date', 
    'venue', 
    'status', 
    'home_score', 
    'away_score',
    'round_number',
    'referee_id'
];

    // Add this to handle the date/time correctly
    protected $casts = [
        'started_at' => 'datetime',
        'match_date' => 'datetime',
    ];

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function referee()
    {
        return $this->belongsTo(User::class, 'referee_id');
    }

    
    
}