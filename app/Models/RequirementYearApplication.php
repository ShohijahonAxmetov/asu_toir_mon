<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequirementYearApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_application_id',
        'equipment_id',
        'month',
        'technical_resource_id',
        'plan_remont_id',
        'required_quantity',
        'warehouse_number',
        'warehouse_date',
        'warehouse_quantity',
        'declared_quantity',
        'delivery_date'
    ];

    public function yearApplication()
    {
        return $this->belongsTo(YearApplication::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function planRemont()
    {
        return $this->belongsTo(PlanRemont::class);
    }
}
