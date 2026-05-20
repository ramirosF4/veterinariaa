@extends('layouts.main')

@section('hide_sidebar', true)

@section('titulo_pagina', 'Consultas de ' . $mascota->nombre)

@section('contenido')
    <h1 class="h3 mb-4 text-gray-800 font-weight-light">Historial de Consultas</h1>

    <!-- Tarjeta de Información -->
    <div class="card shadow mb-4 border-left-info">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <!-- Información del Expediente -->
                <div class="col-md-6 border-right">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-2">Expediente</div>
                    <div class="d-flex align-items-center mb-1">
                        <i class="fas fa-paw fa-3x text-info mr-3"></i>
                        <div>
                            <h4 class="h5 mb-0 font-weight-bold text-gray-800">{{ $mascota->nombre }}</h4>
                            <div class="text-xs text-gray-500 mt-1">
                                Folio #{{ $mascota->id }} &bull; {{ $mascota->especie }} / {{ $mascota->raza }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Dueño -->
                <div class="col-md-4 text-center border-right">
                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">Dueño</div>
                    <div class="text-sm font-weight-bold text-gray-800 mb-1">
                        <i class="fas fa-user text-gray-500 mr-1"></i> {{ $mascota->dueno ? $mascota->dueno->nombre_completo : 'N/A' }}
                    </div>
                    <div class="text-xs text-gray-500">
                        <i class="fas fa-phone mr-1"></i> {{ $mascota->dueno && $mascota->dueno->telefono ? $mascota->dueno->telefono : 'Sin teléfono' }}
                    </div>
                </div>

                <!-- Botón Volver -->
                <div class="col-md-2 text-center mt-3 mt-md-0">
                    <a href="{{ route('expedientes.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta de Historial de Consultas -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-stethoscope mr-2"></i>Consultas Registradas
            </h6>
            <button class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Nueva Consulta
            </button>
        </div>
        <div class="card-body p-0">
            @if($mascota->consultas && $mascota->consultas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-gray-800 text-sm">
                        <thead class="bg-light text-gray-600">
                            <tr>
                                <th class="border-0">#</th>
                                <th class="border-0">Fecha</th>
                                <th class="border-0">Veterinario</th>
                                <th class="border-0">Peso</th>
                                <th class="border-0">Talla</th>
                                <th class="border-0">Diagnóstico</th>
                                <th class="border-0 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mascota->consultas->sortByDesc('fecha_consulta') as $consulta)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle text-primary font-weight-bold">
                                    <i class="far fa-calendar-alt mr-1"></i> {{ $consulta->fecha_consulta ? $consulta->fecha_consulta->format('d/m/Y H:i') : ($consulta->created_at ? $consulta->created_at->format('d/m/Y H:i') : 'N/A') }}
                                </td>
                                <td class="align-middle">{{ $consulta->veterinario ? $consulta->veterinario->name : '—' }}</td>
                                <td class="align-middle">{{ $consulta->peso ? $consulta->peso . ' kg' : '—' }}</td>
                                <td class="align-middle">{{ $consulta->talla ? $consulta->talla . ' cm' : '—' }}</td>
                                <td class="align-middle">{{ $consulta->diagnostico ?? '—' }}</td>
                                <td class="align-middle text-center">
                                    <button class="btn btn-sm btn-info shadow-sm">
                                        <i class="fas fa-eye fa-sm text-white-50 mr-1"></i> Ver
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500 mb-0">No hay consultas registradas para este paciente.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
