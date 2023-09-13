<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequirementRepairApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_application_id',
        'technical_resource_id',
        'required_quantity',
        'warehouse_number',
        'warehouse_date',
        'warehouse_quantity',
        'declared_quantity',
        'delivery_date'
    ];

}
