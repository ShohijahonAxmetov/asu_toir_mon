<?php

namespace App\Models\Catalog;

use App\Models\TechMaps\TechMap;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityMeasure extends Model
{
    use HasFactory;

    protected $fillable = [
    	'title',
    	'desc',
    	'tech_map_id',
    ];

    public function techMaps()
    {
        return $this->belongsToMany(TechMap::class);
    }
}
