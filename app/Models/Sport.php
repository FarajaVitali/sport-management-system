<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sport extends Model
{
    // Define the relationship: A sport has many rules
    public function rules(): HasMany
    {
        return $this->hasMany(Rule::class);
    }
}