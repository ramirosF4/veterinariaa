<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedentePatologico extends Model
{
    use HasFactory;

    protected $fillable = [
        'mascota_id',
        'enfermedad',
        'es_cronica',
    ];

    protected $casts = [
        'es_cronica' => 'boolean',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }
}
