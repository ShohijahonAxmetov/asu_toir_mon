<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'technical_resource_id',
        'unit_id',
        'quantity',
        'quantity_m1',
        'quantity_m2',
        'quantity_m3',
        'quantity_m4',
        'quantity_m5',
        'quantity_m6',
        'quantity_m7',
        'quantity_m8',
        'quantity_m9',
        'quantity_m10',
        'quantity_m11',
        'quantity_m12',
        'year',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function technicalResource()
    {
        return $this->belongsTo(TechnicalResource::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function requirements()
    {
        return $this->hasMany(RequirementYearApplication::class);
    }
}
