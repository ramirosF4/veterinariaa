<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedenteLesion extends Model
{
    use HasFactory;

    protected $fillable = [
        'mascota_id',
        'tipo_lesion',
        'ubicacion',
        'gravedad',
        'fecha_lesion',
        'descripcion',
        'imagen_path',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }
}
