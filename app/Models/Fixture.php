<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fixture extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'round_number',
        'match_date',
        'status',
    ];

    /**
     * Get the home team competing in this fixture.
     */
    public function homeTeam(): BelongsTo
    {
        // Explicitly map home_team_id to the Team model
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    /**
     * Get the away team competing in this fixture.
     */
    public function awayTeam(): BelongsTo
    {
        // Explicitly map away_team_id to the Team model
        return $this->belongsTo(Team::class, 'away_team_id');
    }
}