<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalInspection extends Model
{
    use HasFactory;

    protected $fillable = ['detail_id', 'type_technical_inspection_id', 'who_conducted', 'desc', 'now', 'next'];

    public function detail(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Detail::class);
    }

    public function type_technical_inspection(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TypeTechnicalInspection::class);
    }
}
