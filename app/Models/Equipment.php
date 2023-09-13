<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_equipment_id',
        'garage_number'
    ];

    public function typeEquipment()
    {
        return $this->belongsTo(TypeEquipment::class);
    }

    public function planRemonts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PlanRemont::class);
    }

}
