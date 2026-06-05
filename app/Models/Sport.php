<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sport extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Get the teams configured under this sport category.
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}