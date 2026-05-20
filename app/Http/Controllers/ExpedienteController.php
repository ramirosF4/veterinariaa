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

    public function verConsulta($id, $consulta_id)
    {
        $mascota = Mascota::with([
            'dueno', 
            'antecedenteAlergias', 
            'antecedenteLesiones', 
            'antecedentePatologicos', 
            'historialAlimentaciones'
        ])->findOrFail($id);

        $consulta = \App\Models\Consulta::with('veterinario')
            ->where('id', $consulta_id)
            ->where('mascota_id', $id)
            ->firstOrFail();

        return view('modules.expedientes.consulta_detalle', compact('mascota', 'consulta'));
    }

    public function diagnostico($id, $consulta_id)
    {
        $mascota = Mascota::findOrFail($id);
        $consulta = \App\Models\Consulta::query()->where('id', $consulta_id)
            ->where('mascota_id', $id)
            ->firstOrFail();

        return view('modules.expedientes.diagnostico', compact('mascota', 'consulta'));
    }

    public function guardarDiagnostico(Request $request, $id, $consulta_id)
    {
        $request->validate([
            'diagnostico' => 'nullable|string'
        ]);

        $consulta = \App\Models\Consulta::query()->where('id', $consulta_id)
            ->where('mascota_id', $id)
            ->firstOrFail();

        $esNuevo = empty($consulta->diagnostico);

        $consulta->diagnostico = $request->input('diagnostico');
        $consulta->save();

        $mensaje = $esNuevo ? 'Se guardó la nueva información con éxito.' : 'Se actualizó con éxito.';

        return redirect()->route('expedientes.consultas.diagnostico', ['id' => $id, 'consulta_id' => $consulta_id])
            ->with('success', $mensaje);
    }

    public function tratamiento($id, $consulta_id)
    {
        $mascota = Mascota::findOrFail($id);
        $consulta = \App\Models\Consulta::query()->where('id', $consulta_id)
            ->where('mascota_id', $id)
            ->firstOrFail();

        return view('modules.expedientes.tratamiento', compact('mascota', 'consulta'));
    }

    public function guardarTratamiento(Request $request, $id, $consulta_id)
    {
        $request->validate([
            'tratamiento' => 'nullable|string'
        ]);

        $consulta = \App\Models\Consulta::query()->where('id', $consulta_id)
            ->where('mascota_id', $id)
            ->firstOrFail();

        $esNuevo = empty($consulta->tratamiento);

        $consulta->tratamiento = $request->input('tratamiento');
        $consulta->save();

        $mensaje = $esNuevo ? 'Se guardó la nueva información con éxito.' : 'Se actualizó con éxito.';

        return redirect()->route('expedientes.consultas.tratamiento', ['id' => $id, 'consulta_id' => $consulta_id])
            ->with('success', $mensaje);
    }
}
