<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rule extends Model
{
    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }
}