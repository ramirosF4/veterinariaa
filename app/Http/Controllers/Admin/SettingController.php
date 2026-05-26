<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Obtener todas las configuraciones y mapearlas como clave => valor
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        
        return view('modules.admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method', 'clinic_logo']);

        if ($request->hasFile('clinic_logo')) {
            $path = $request->file('clinic_logo')->store('logos', 'public');
            \App\Models\Setting::updateOrCreate(
                ['key' => 'clinic_logo'],
                ['value' => $path]
            );
        }

        foreach ($data as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Limpiar la caché si se estuviera usando (ej. Cache::forget('settings'))

        return redirect()->route('admin.settings.index')
                         ->with('success', 'Configuraciones actualizadas correctamente.');
    }
}
