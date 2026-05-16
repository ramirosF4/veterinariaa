<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionSistema extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_clinica',
        'mision',
        'vision',
        'valores',
        'historia',
        'precios_servicios',
        'direccion_fisica',
        'telefono_contacto',
        'logo_path',
    ];

    protected $casts = [
        'precios_servicios' => 'array',
    ];
}
