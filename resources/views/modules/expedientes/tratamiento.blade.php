@extends('layouts.main')

@section('titulo_pagina', 'Tratamiento')

@push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="{{ asset('css/expedientes-custom.css') }}" rel="stylesheet">
@endpush

@section('contenido')
    <h1 class="h3 mb-4 text-gray-800 font-weight-light">Tratamiento de la Consulta</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Breadcrumbs (Migajas de pan) --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body py-3 d-flex align-items-center">
            <span class="text-primary font-weight-bold">Expedientes</span>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-primary">{{ $mascota->nombre }}</span>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-primary">Consulta #{{ $consulta->id }}</span>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-600">Tratamiento</span>
        </div>
    </div>

    {{-- Encabezado de Mascota y Consulta --}}
    <div class="card shadow-sm mb-4 border-left-primary">
        <div class="card-body py-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fas fa-paw fa-3x text-primary mr-3"></i>
                    <div>
                        <h4 class="h5 mb-0 font-weight-bold text-gray-800">{{ $mascota->nombre }}</h4>
                        <div class="text-xs text-gray-500 mt-1">
                            Folio #{{ $mascota->id }} &bull; {{ $mascota->especie }} / {{ $mascota->raza }}
                        </div>
                    </div>
                </div>
                <div>
                    <span class="btn btn-primary btn-sm shadow-sm pe-none">
                        <i class="far fa-calendar-alt mr-1"></i> Consulta del {{ $consulta->fecha_consulta ? $consulta->fecha_consulta->format('d/m/Y') : ($consulta->created_at ? $consulta->created_at->format('d/m/Y') : 'N/A') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección de Tratamiento con Formulario --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-pills mr-2"></i>Tratamiento Médico / Receta
            </h6>
            @if(!empty($consulta->tratamiento))
                <span class="badge badge-success px-3 py-2 text-sm shadow-sm">
                    <i class="fas fa-check-circle mr-1"></i> Registrado
                </span>
            @endif
        </div>
        <div class="card-body">
            <form id="tratamientoForm" action="{{ route('expedientes.consultas.tratamiento.guardar', ['id' => $mascota->id, 'consulta_id' => $consulta->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <h6 class="font-weight-bold text-gray-800 mb-3">
                        <i class="fas fa-notes-medical text-warning mr-2"></i>Descripción del tratamiento
                    </h6>
                    @if(empty($consulta->tratamiento))
                        <div class="alert alert-light border text-muted mb-3 text-center">
                            <i class="fas fa-info-circle mr-1"></i> Aún sin tratamiento
                        </div>
                    @endif
                    
                    <input type="hidden" name="tratamiento" id="tratamientoInput">
                    <div id="editor-container" class="bg-white" data-placeholder="Escriba el tratamiento detallado o receta aquí..." data-input-target="tratamientoInput">{!! $consulta->tratamiento !!}</div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success px-4 shadow-sm">
                        <i class="fas fa-save mr-1"></i> Guardar Tratamiento
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="{{ asset('js/quill-setup.js') }}"></script>
@endpush
