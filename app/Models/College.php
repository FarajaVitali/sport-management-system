<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    // Add this line to allow saving the name
    protected $fillable = ['name'];

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}