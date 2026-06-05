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
        'user_id', 
        'college_id', 
        'team', 
        'jersey_number', 
        'position'
    ];

    /**
     * Link the profile back to the User account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class, 'college_id');
    }
}