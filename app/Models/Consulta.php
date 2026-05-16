<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'mascota_id',
        'veterinario_id',
        'fecha_consulta',
        'peso',
        'talla',
        'diagnostico',
        'tratamiento',
    ];

    protected $casts = [
        'fecha_consulta' => 'datetime',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function veterinario()
    {
        return $this->belongsTo(Veterinario::class);
    }
}
