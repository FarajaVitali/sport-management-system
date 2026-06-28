<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fixture extends Model
{
    protected $fillable = [
        'home_team_id', 
        'away_team_id', 
        'round_number', 
        'match_date', 
        'venue', 
        'status', 
        'home_score', 
        'away_score', 
        'started_at', 
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
}