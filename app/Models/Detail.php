<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;

    protected $fillable = ['equipment_id', 'type_technical_inspection_id', 'name', 'desc', 'planned'];

    protected $appends = ['days'];
    public function getDaysAttribute()
    {
        $raznica = strtotime($this->planned) - time();
        $raznica = $raznica/60/60/24;
        if($raznica <= 0) $raznica = null;

        return (int)$raznica;
    }

    public function equipment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function technical_inspections(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TechnicalInspection::class);
    }

    public function type_technical_inspection(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TypeTechnicalInspection::class);
    }
}
