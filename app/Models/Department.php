<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id'
    ];

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

}
