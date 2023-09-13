<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'catalog_name',
        'catalog_number',
        'nomen_name',
        'nomen_number',
        'time_complete_order',
        'delivery_time'
    ];

    public function technicalResourceTypeEquipments()
    {
        return $this->hasMany(TechnicalResourceTypeEquipment::class);
    }
}
