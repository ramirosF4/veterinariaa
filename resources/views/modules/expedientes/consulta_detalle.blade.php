@extends('layouts.main')

@section('titulo_pagina', 'Detalle de Consulta')

@section('contenido')
    <!-- Migajas de Pan -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white border-left-primary shadow-sm rounded mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('expedientes.index') }}">Expedientes</a></li>
            <li class="breadcrumb-item"><a href="{{ route('expedientes.consultas', $mascota->id) }}">Consultas de {{ $mascota->nombre }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detalle de Consulta</li>
        </ol>
    </nav>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-notes-medical mr-2 text-primary"></i>Detalles de Consulta Médica
        </h1>
        <a href="{{ route('expedientes.consultas', $mascota->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Volver a Consultas
        </a>
    </div>

    <div class="row">
        <!-- Detalles de la Consulta -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4 border-bottom-primary">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-medical-alt mr-2"></i>Información de la Consulta
                    </h6>
                    <span class="badge badge-primary px-3 py-2 text-sm">
                        <i class="far fa-calendar-alt mr-1"></i> {{ $consulta->fecha_consulta ? $consulta->fecha_consulta->format('d/m/Y H:i') : ($consulta->created_at ? $consulta->created_at->format('d/m/Y H:i') : 'N/A') }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4 bg-light p-3 rounded mx-0">
                        <div class="col-md-4 mb-3 mb-md-0 border-right">
                            <div class="text-xs font-weight-bold text-uppercase text-muted mb-1">Paciente</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $mascota->nombre }}</div>
                            <div class="small text-gray-500">{{ $mascota->especie }} / {{ $mascota->raza }}</div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0 border-right pl-md-4">
                            <div class="text-xs font-weight-bold text-uppercase text-muted mb-1">Veterinario Tratante</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                <i class="fas fa-user-md text-info mr-1"></i> {{ $consulta->veterinario ? $consulta->veterinario->name : 'N/A' }}
                            </div>
                        </div>
                        <div class="col-md-2 col-6 text-center border-right">
                            <div class="text-xs font-weight-bold text-uppercase text-muted mb-1">Peso</div>
                            <div class="h5 mb-0 font-weight-bold text-primary">{{ $consulta->peso ? $consulta->peso . ' kg' : '—' }}</div>
                        </div>
                        <div class="col-md-2 col-6 text-center">
                            <div class="text-xs font-weight-bold text-uppercase text-muted mb-1">Talla</div>
                            <div class="h5 mb-0 font-weight-bold text-primary">{{ $consulta->talla ? $consulta->talla . ' cm' : '—' }}</div>
                        </div>
                    </div>

                  
                </div>
            </div>
        </div>

        <!-- Antecedentes de la Mascota -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Antecedentes Médicos
                    </h6>
                </div>
                <div class="card-body">
                    
                    {{-- Alergias --}}
                    <div class="mb-4">
                        <div class="text-xs font-weight-bold text-uppercase text-danger mb-2">Alergias</div>
                        @if($mascota->antecedenteAlergias && $mascota->antecedenteAlergias->count() > 0)
                            <ul class="list-group list-group-flush small">
                                @foreach($mascota->antecedenteAlergias as $alergia)
                                    <li class="list-group-item px-0 py-1 border-0">
                                        <i class="fas fa-allergies text-danger mr-2"></i>
                                        <strong>{{ $alergia->sustancia_alergena }}</strong> 
                                        @if($alergia->reaccion) 
                                            <span class="text-muted">- Reacción: {{ $alergia->reaccion }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="small text-muted p-2 bg-light rounded"><i class="fas fa-check-circle text-success mr-1"></i> No reporta alergias conocidas.</div>
                        @endif
                    </div>

                    {{-- Lesiones Previas --}}
                    <div class="mb-4">
                        <div class="text-xs font-weight-bold text-uppercase text-warning mb-2">Lesiones / Cirugías Previas</div>
                        @if($mascota->antecedenteLesiones && $mascota->antecedenteLesiones->count() > 0)
                            <ul class="list-group list-group-flush small">
                                @foreach($mascota->antecedenteLesiones as $lesion)
                                    <li class="list-group-item px-0 py-1 border-0">
                                        <i class="fas fa-band-aid text-warning mr-2"></i> {{ $lesion->tipo_lesion }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="small text-muted p-2 bg-light rounded"><i class="fas fa-check-circle text-success mr-1"></i> No reporta lesiones o cirugías.</div>
                        @endif
                    </div>

                    {{-- Antecedentes Patológicos --}}
                    <div class="mb-4">
                        <div class="text-xs font-weight-bold text-uppercase text-info mb-2">Patológicos (Enfermedades)</div>
                        @if($mascota->antecedentePatologicos && $mascota->antecedentePatologicos->count() > 0)
                            <ul class="list-group list-group-flush small">
                                @foreach($mascota->antecedentePatologicos as $patologico)
                                    <li class="list-group-item px-0 py-1 border-0">
                                        <i class="fas fa-virus text-info mr-2"></i>
                                        {{ $patologico->enfermedad }}
                                        @if($patologico->es_cronica)
                                            <span class="badge badge-danger ml-1">Crónica</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="small text-muted p-2 bg-light rounded"><i class="fas fa-check-circle text-success mr-1"></i> Sin enfermedades reportadas.</div>
                        @endif
                    </div>

                    {{-- Alimentación --}}
                    <div class="mb-2">
                        <div class="text-xs font-weight-bold text-uppercase text-success mb-2">Historial de Alimentación</div>
                        @if($mascota->historialAlimentaciones && $mascota->historialAlimentaciones->count() > 0)
                            <ul class="list-group list-group-flush small">
                                @foreach($mascota->historialAlimentaciones as $alimento)
                                    <li class="list-group-item px-0 py-1 border-0">
                                        <i class="fas fa-bone text-success mr-2"></i>
                                        {{ $alimento->descripcion_dieta }} 
                                        @if($alimento->frecuencia_diaria)
                                            <span class="text-muted">({{ $alimento->frecuencia_diaria }} al día)</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="small text-muted p-2 bg-light rounded"><i class="fas fa-info-circle text-info mr-1"></i> Sin registros de dieta especial.</div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
