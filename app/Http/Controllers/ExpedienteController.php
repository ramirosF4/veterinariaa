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

    public function storeConsulta(Request $request, $id)
    {
        $mascota = Mascota::findOrFail($id);

        $consulta = new \App\Models\Consulta();
        $consulta->mascota_id = $id;
        // Si el usuario autenticado es veterinario, se asigna como el doctor de la consulta
        $consulta->veterinario_id = (auth()->user()->role === 'veterinario' && auth()->user()->veterinario) 
            ? auth()->user()->veterinario->id 
            : null;
        $consulta->fecha_consulta = now();
        $consulta->save();

        return redirect()->route('expedientes.consultas.ver', ['id' => $id, 'consulta_id' => $consulta->id])
            ->with('success', 'Nueva consulta iniciada. Puede capturar los detalles ahora.');
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

    public function alergias($id)
    {
        $mascota = Mascota::with('antecedenteAlergias')->findOrFail($id);
        return view('modules.expedientes.alergias', compact('mascota'));
    }

    public function guardarAlergia(Request $request, $id)
    {
        $request->validate([
            'sustancia_alergena' => 'required|string|max:255',
            'reaccion' => 'nullable|string|max:255',
        ]);

        $mascota = Mascota::findOrFail($id);
        
        $mascota->antecedenteAlergias()->create([
            'sustancia_alergena' => $request->input('sustancia_alergena'),
            'reaccion' => $request->input('reaccion'),
        ]);

        return redirect()->route('expedientes.alergias', $id)
            ->with('success', 'Alergia registrada exitosamente.');
    }

    public function eliminarAlergia($id, $alergia_id)
    {
        $mascota = Mascota::findOrFail($id);
        $alergia = $mascota->antecedenteAlergias()->findOrFail($alergia_id);
        
        $alergia->delete();

        return redirect()->route('expedientes.alergias', $id)
            ->with('success', 'Alergia eliminada exitosamente.');
    }

    public function patologicos($id)
    {
        $mascota = Mascota::with('antecedentePatologicos')->findOrFail($id);
        return view('modules.expedientes.patologicos', compact('mascota'));
    }

    public function guardarPatologico(Request $request, $id)
    {
        $request->validate([
            'enfermedad' => 'required|string|max:255',
        ]);

        $mascota = Mascota::findOrFail($id);
        
        $mascota->antecedentePatologicos()->create([
            'enfermedad' => $request->input('enfermedad'),
            'es_cronica' => $request->has('es_cronica'),
        ]);

        return redirect()->route('expedientes.patologicos', $id)
            ->with('success', 'Enfermedad registrada exitosamente.');
    }

    public function eliminarPatologico($id, $patologico_id)
    {
        $mascota = Mascota::findOrFail($id);
        $patologico = $mascota->antecedentePatologicos()->findOrFail($patologico_id);
        
        $patologico->delete();

        return redirect()->route('expedientes.patologicos', $id)
            ->with('success', 'Registro eliminado exitosamente.');
    }
    public function lesiones($id)
    {
        $mascota = Mascota::with('antecedenteLesiones')->findOrFail($id);
        return view('modules.expedientes.lesiones', compact('mascota'));
    }

    public function guardarLesion(Request $request, $id)
    {
        $request->validate([
            'tipo_lesion' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'gravedad' => 'nullable|string|max:255',
            'fecha_lesion' => 'nullable|date',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $mascota = Mascota::findOrFail($id);
        
        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('lesiones', 'public');
        }
        
        $mascota->antecedenteLesiones()->create([
            'tipo_lesion' => $request->input('tipo_lesion'),
            'ubicacion' => $request->input('ubicacion'),
            'gravedad' => $request->input('gravedad'),
            'fecha_lesion' => $request->input('fecha_lesion'),
            'descripcion' => $request->input('descripcion'),
            'imagen_path' => $imagenPath,
        ]);

        return redirect()->route('expedientes.lesiones', $id)
            ->with('success', 'Lesión registrada exitosamente.');
    }

    public function eliminarLesion($id, $lesion_id)
    {
        $mascota = Mascota::findOrFail($id);
        $lesion = $mascota->antecedenteLesiones()->findOrFail($lesion_id);
        
        if ($lesion->imagen_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($lesion->imagen_path);
        }

        $lesion->delete();

        return redirect()->route('expedientes.lesiones', $id)
            ->with('success', 'Lesión eliminada exitosamente.');
    }
    public function alimentacion($id)
    {
        // Ordenar de más reciente a más antiguo
        $mascota = Mascota::with(['historialAlimentaciones' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        return view('modules.expedientes.alimentacion', compact('mascota'));
    }

    public function guardarAlimentacion(Request $request, $id)
    {
        $request->validate([
            'tipo_alimento' => 'required|string|max:255',
            'marca_producto' => 'nullable|string|max:255',
            'cantidad_porcion' => 'nullable|string|max:255',
            'frecuencia_diaria' => 'required|integer|min:1',
            'horarios_comida' => 'nullable|string|max:255',
            'descripcion_dieta' => 'required|string',
            'observaciones' => 'nullable|string',
        ]);

        $mascota = Mascota::findOrFail($id);
        
        $mascota->historialAlimentaciones()->create([
            'tipo_alimento' => $request->input('tipo_alimento'),
            'marca_producto' => $request->input('marca_producto'),
            'cantidad_porcion' => $request->input('cantidad_porcion'),
            'frecuencia_diaria' => $request->input('frecuencia_diaria'),
            'horarios_comida' => $request->input('horarios_comida'),
            'descripcion_dieta' => $request->input('descripcion_dieta'),
            'observaciones' => $request->input('observaciones'),
        ]);

        return redirect()->route('expedientes.alimentacion', $id)
            ->with('success', 'Dieta alimenticia registrada exitosamente.');
    }

    public function eliminarAlimentacion($id, $alimentacion_id)
    {
        $mascota = Mascota::findOrFail($id);
        $alimentacion = $mascota->historialAlimentaciones()->findOrFail($alimentacion_id);
        
        $alimentacion->delete();

        return redirect()->route('expedientes.alimentacion', $id)
            ->with('success', 'Registro de alimentación eliminado exitosamente.');
    }
}
