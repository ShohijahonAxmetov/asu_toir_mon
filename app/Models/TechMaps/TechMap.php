<?php

namespace App\Models\TechMaps;

use App\Models\TechMaps\TechOperation;
use App\Models\Catalog\SecurityMeasure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechMap extends Model
{
    use HasFactory;

    protected $fillable = [
    	'tech_map_group_id',
    	'title',
    	'agreed_at',
    	'code',
    	'hours',
    	'minutes',
    	'comments'
    ];

    protected $appends = [
        'amount',
    ];

    protected function casts(): array
    {
        return [
            'agreed_at' => 'date',
        ];
    }

    public function techMapGroup(): BelongsTo
    {
    	return $this->belongsTo(TechMapGroup::class);
    }

    public function techOperations(): BelongsToMany
    {
    	return $this->belongsToMany(TechOperation::class);
    }

    public function techOperationStages(): BelongsToMany
    {
    	return $this->belongsToMany(TechOperationStage::class);
    }

    public function techMaps(): BelongsToMany
    {
    	return $this->belongsToMany(TechMap::class);
    }

    public function securityMeasures(): BelongsToMany
    {
        return $this->belongsToMany(SecurityMeasure::class)->withPivot('id');
    }

    public function onlyTechOperations(): Collection
    {
        $techOperationsIds = DB::table('tech_map_operations')
            ->where([
                ['tech_map_id', $this->id],
                ['model', 'App\Models\TechMaps\TechOperation']
            ])
            ->pluck('model_id')
            ->toArray();

        return TechOperation::whereIn('id', $techOperationsIds)
            ->get();
    }

    public function getAmountAttribute()
    {
        return $this->onlyTechOperations()->sum('amount');
    }
}
