<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedenteAlergia extends Model
{
    use HasFactory;

    protected $fillable = [
        'mascota_id',
        'sustancia_alergena',
        'reaccion',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }
}
