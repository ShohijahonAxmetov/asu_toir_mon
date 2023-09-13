<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalResourceTypeEquipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_equipment_id',
        'technical_resource_id',
        'parent_id'
    ];

    public function typeEquipment()
    {
        return $this->belongsTo(TypeEquipment::class);
    }

    public function technicalResource()
    {
        return $this->belongsTo(TechnicalResource::class);
    }

    public function parent()
    {
        return $this->hasOne(TechnicalResourceTypeEquipment::class, 'parent_id');
    }
}
