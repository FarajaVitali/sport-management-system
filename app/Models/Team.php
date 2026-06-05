<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    // Allows saving these specific columns via mass assignment
    protected $fillable = ['name', 'college_id', 'sport_id', 'coach_name'];
    /**
     * Get the college that owns the team.
     */
    public function college()
    {
        return $this->belongsTo(College::class);
    }

    /**
     * Get the sport that the team plays.
     */
    public function sport()
{
    return $this->belongsTo(Sport::class);
}
}


