<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'order_number',
        'order_date',
        'order_quantity',
        'contract_number',
        'contract_date',
        'local_foreign',
        'payment_date',
        'date_manufacture_contract',
        'date_manufacture_fact',

        'exit_date', // data. kogda pokinul zavod

        'customs_date_receipt',
        'customs_date_exit',
        'date_delivery_object',
        'execution_statuse_id'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function executionStatuse()
    {
        return $this->belongsTo(ExecutionStatus::class);
    }

    public function technicalResource()
    {

    }
}
