<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'college_id',
        'sport_id',
        'gender' // <-- ADDED THIS FOR GENDER PASS-THROUGH
    ];

    /**
     * Get the coach profile associated with the team roster.
     */
    public function coachProfile()
    {
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
    // app/Models/Team.php

public function sport()
{
    // Adjust 'sport_id' if your foreign key has a different name
    return $this->belongsTo(Sport::class, 'sport_id');
}
}