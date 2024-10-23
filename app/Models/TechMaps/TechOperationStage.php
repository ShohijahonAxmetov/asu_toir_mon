<?php

namespace App\Models\TechMaps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechOperationStage extends Model
{
    use HasFactory;

    protected $fillable = [
    	'title',
    	'desc',
    ];

    public function techOperations(): HasMany
    {
    	return $this->hasMany(TechOperation::class);
    }

    public function techMaps(): BelongsToMany
    {
    	return $this->belongsToMany(TechMap::class);
    }
}
