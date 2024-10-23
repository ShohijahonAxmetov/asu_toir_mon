<?php

namespace App\Models\Repair;

use App\Models\TechMaps\TechMap;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
    	'tech_map_id',
    	'started_at',
    	'ended_at',
    	'comments',
        'amount',
    ];

    public function techMap(): BelongsTo
	{
		return $this->belongsTo(TechMap::class);
	}

	public function repairLogs(): HasMany
	{
		return $this->hasMany(RepairLog::class);
	}
}
