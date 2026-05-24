<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialAlimentacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'mascota_id',
        'descripcion_dieta',
        'frecuencia_diaria',
        'tipo_alimento',
        'marca_producto',
        'cantidad_porcion',
        'observaciones',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }
}
