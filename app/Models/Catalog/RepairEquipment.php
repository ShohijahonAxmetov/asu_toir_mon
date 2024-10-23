<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairEquipment extends Model
{
    use HasFactory;

    protected $table = 'repair_equipments';

    protected $fillable = [
    	'title',
    	'desc'
    ];
}
