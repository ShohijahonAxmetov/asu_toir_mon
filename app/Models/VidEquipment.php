<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VidEquipment extends Model
{
    use HasFactory;

    protected $table = 'vid_equipments';

    protected $fillable = [
        'name'
    ];

    public function typeEquipments()
    {
        return $this->hasMany(Equipment::class);
    }
 
}
