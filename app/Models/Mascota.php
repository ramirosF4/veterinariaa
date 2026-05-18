<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Mascota extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'dueno_id',
        'nombre',
        'especie',
        'raza',
        'fecha_nacimiento',
        'tipo_sangre',
        'comportamiento',
        'es_adoptado',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'es_adoptado' => 'boolean',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'dueno_nombre' => $this->dueno ? $this->dueno->nombre_completo : '',
        ];
    }

    public function dueno()
    {
        return $this->belongsTo(Dueno::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }

    public function antecedenteAlergias()
    {
        return $this->hasMany(AntecedenteAlergia::class);
    }

    public function antecedenteLesiones()
    {
        return $this->hasMany(AntecedenteLesion::class);
    }

    public function antecedentePatologicos()
    {
        return $this->hasMany(AntecedentePatologico::class);
    }

    public function historialAlimentaciones()
    {
        return $this->hasMany(HistorialAlimentacion::class);
    }
}
