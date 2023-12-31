<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_equipment_id',
        'department_id',
        'garage_number',
        'commissioning_date',
        'eq_condition',
    ];

    public function typeEquipment()
    {
        return $this->belongsTo(TypeEquipment::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function planRemonts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PlanRemont::class);
    }

    public function repairApplications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RepairApplication::class);
    }
}