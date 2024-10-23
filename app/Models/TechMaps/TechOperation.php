<?php

namespace App\Models\TechMaps;

use App\Models\Catalog\RepairEquipment;
use App\Models\Catalog\Instrument;
use App\Models\Catalog\Qualification;
use App\Models\TechnicalResource;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechOperation extends Model
{
    use HasFactory;

    protected $fillable = [
    	'tech_operation_stage_id',
    	'title',
    	'full_title',
    	'hours',
    	'minutes',
    	'amount',
    	'content',
    	'comments'
    ];

    public function techOperationStage(): BelongsTo
    {
    	return $this->belongsTo(TechOperationStage::class);
    }

    public function techMaps(): BelongsToMany
    {
    	return $this->belongsToMany(TechMap::class);
    }

    public function technicalResources(): BelongsToMany
    {
        return $this->belongsToMany(TechnicalResource::class)
            ->withPivot('id', 'quantity', 'unit_id', 'characteristics');
    }

    public function qualifications(): BelongsToMany
    {
        return $this->belongsToMany(Qualification::class)
            ->withPivot('id', 'count', 'hours', 'minutes', 'characteristics');
    }

    public function instruments(): BelongsToMany
    {
        return $this->belongsToMany(Instrument::class)
            ->withPivot('id', 'count', 'characteristics');
    }

    public function repairEquipments(): BelongsToMany
    {
        return $this->belongsToMany(RepairEquipment::class)
            ->withPivot('id', 'count', 'hours', 'minutes', 'characteristics');
    }
}
