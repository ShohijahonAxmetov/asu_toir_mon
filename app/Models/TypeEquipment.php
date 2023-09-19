<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeEquipment extends Model
{
    use HasFactory;

    protected $table = 'type_equipments';

    protected $fillable = [
        'name',
        'vid_equipment_id'
    ];

    public function vidEquipment()
    {
        return $this->belongsTo(VidEquipment::class);
    }

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    public function technicalResourceTypeEquipments()
    {
        return $this->hasMany(TechnicalResourceTypeEquipment::class);
    }
}
