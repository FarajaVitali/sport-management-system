<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Removed 'coach_name' to support clean relational binding.
     */
    protected $fillable = [
        'name',
        'college_id',
        'sport_id'
    ];

    /**
     * Get the coach profile associated with the team roster.
     */
    public function coachProfile()
    {
        // Links to the coach_profiles table using 'team_id' foreign key
        return $this->hasOne(CoachProfile::class, 'team_id');
    }

    /**
     * Get the parent academic institution / college that owns the team squad.
     */
    public function college()
    {
        return $this->belongsTo(College::class);
    }

    /**
     * Get the tournament sport category configuration.
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
}