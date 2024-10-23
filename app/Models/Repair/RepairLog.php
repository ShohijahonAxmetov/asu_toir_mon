<?php

namespace App\Models\Repair;

use App\Models\TechMaps\TechMap;
use App\Models\TechMaps\TechOperation;
use App\Models\Repair\Repair;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairLog extends Model
{
    use HasFactory;

    protected $fillable = [
    	'repair_id',
    	'tech_map_id',
    	'tech_map_tech_operation_id',
    	'tech_operations',
    	'tech_operation_id',
    	'duration_hours',
    	'duration_minutes',
    	'comments',
    ];

    public function repair(): BelongsTo
    {
    	return $this->belongsTo(Repair::class);
    }

    public function techMap(): BelongsTo
    {
    	return $this->belongsTo(TechMap::class);
    }

    public function techMapTechOperation(): BelongsTo
    {
    	return $this->belongsTo(TechOperation::class);
    }

    public function techOperation(): BelongsTo
    {
    	return $this->belongsTo(TechOperation::class);
    }

    public function deviation(): string
    {
        $normative = $this->techOperation->hours*60 + $this->techOperation->minutes;
        $fact = $this->duration_hours*60 + $this->duration_minutes;

        $result = $fact-$normative;

        return $result == 0
            ? '-'
            : ($result < -60
                    ? '-'.(floor($result/60)+1).' ч '.abs($result%60).' м'
                    : ($result == -60 ? '' : '+').floor($result/60).' ч '.($result%60).' м');
    }
}
