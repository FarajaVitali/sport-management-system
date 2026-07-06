<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     * Crucial: Includes college_id so it saves when the form is submitted!
     */
   protected $fillable = [
    'user_id', 'college_id','team',
];

    /**
     * Link the profile back to the User account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Link the profile to the College.
     */
    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    /**
     * Get the team this player belongs to.
     * Explicitly pointing to your 'team' column as the foreign key override.
     */
    public function team(): BelongsTo
    {
        // By passing 'team' as the second parameter, Laravel now knows to use 
        // the 'team' column instead of looking for a non-existent 'team_id'.
        return $this->belongsTo(Team::class, 'team');
    }
}