<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_date',
        'equipment_id',
        'plan_remont_id'
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function planRemont()
    {
        return $this->belongsTo(PlanRemont::class);
    }

    public function requirements()
    {
        return $this->hasMany(RequirementEmergencyApplication::class);
    }    
}
