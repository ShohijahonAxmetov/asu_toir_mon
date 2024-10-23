<?php

namespace App\Models\TechMaps;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechMapGroup extends Model
{
    use HasFactory;

    protected $fillable = [
    	'title',
    	'desc',
    ];

    public function techMaps(): HasMany
    {
    	return $this->hasMany(TechMap::class);
    }
}
