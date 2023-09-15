<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemontMove extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_remont_id',
        'remont_begin',
        'remont_end'
    ];

    public function planRemont()
    {
        return $this->belongsTo(PlanRemont::class);
    }
}
