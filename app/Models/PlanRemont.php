<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanRemont extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'remont_type_id',
        'remont_begin',
        'remont_end'
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function remontType()
    {
        return $this->belongsTo(RemontType::class);
    }

    public function remontMoves()
    {
        return $this->hasMany(RemontMove::class);
    }
}
