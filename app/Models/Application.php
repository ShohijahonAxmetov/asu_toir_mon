<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_remont_id',
        'equipment_id',
        'technical_resource_id',
        'required_quantity',
        'warehouse_number',
        'warehouse_date',
        'warehouse_quantity',
        'type_application',
        'requirement_id',
        'application_date',
        'declared_quantity',
        'delivery_date',
        'remont_begin'
    ];

    public function planRemont()
    {
        return $this->belongsTo(PlanRemont::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function technicalResource()
    {
        return $this->belongsTo(TechnicalResource::class);
    }
}
