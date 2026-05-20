<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
    public function index()
    {
        return view('modules.expedientes.index');
    }

    public function buscar(Request $request)
    {
        $query = $request->input('q', '');

        if (empty(trim($query))) {
            return response()->json([]);
        }

        // Búsqueda usando Eloquent directamente para soportar relaciones (dueños)
        // ya que el driver 'database' de Scout es limitado con relaciones externas.
        $resultados = Mascota::with('dueno')
            ->where('id', 'like', "%{$query}%") // Búsqueda por Folio
            ->orWhere('nombre', 'like', "%{$query}%") // Búsqueda por Mascota
            ->orWhereHas('dueno', function ($q) use ($query) {
                // Búsqueda por Nombre del Dueño
                $q->where('nombre_completo', 'like', "%{$query}%");
            })
            ->take(5)
            ->get();

        return response()->json($resultados);
    }

    public function consultas($id)
    {
        $mascota = Mascota::with(['consultas.veterinario', 'dueno'])->findOrFail($id);
        return view('modules.expedientes.consultas', compact('mascota'));
    }
}
