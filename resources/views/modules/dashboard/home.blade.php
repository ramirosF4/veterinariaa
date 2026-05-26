{{-- Dashboard Home — usa el layout principal con sidebar --}}
@extends('layouts.main')

@section('hide_sidebar', true)

@section('titulo_pagina', 'Dashboard')

@section('contenido')

    {{-- Encabezado de página --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
        </h1>
        <span class="text-muted small">
            <i class="fas fa-clock mr-1"></i>
            Bienvenido, {{ Auth::user()->name ?? 'Usuario' }}
        </span>
    </div>

    {{-- Tarjetas de resumen --}}
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pacientes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pacientes'] ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Consultas hoy</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['consultas_hoy'] ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Propietarios</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['propietarios'] ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Citas pendientes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['citas_pendientes'] ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if(isset($veterinario) && $veterinario)
    <div class="row">
        <!-- Tarjeta de Perfil -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom-primary">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-md mr-2"></i>Mi Perfil Profesional</h6>
                </div>
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <div class="mb-3">
                        <div class="bg-gray-200 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                            <i class="fas fa-user-md fa-3x text-gray-500"></i>
                        </div>
                    </div>
                    <h4 class="font-weight-bold text-gray-800 mb-1">{{ $veterinario->nombre_completo ?? Auth::user()->name }}</h4>
                    <div class="mb-3">
                        <span class="badge badge-info px-3 py-2 text-sm shadow-sm">{{ $veterinario->especialidad ?? 'Veterinario' }}</span>
                    </div>
                    
                    <hr class="w-75 mx-auto">
                    
                    <div class="text-left px-xl-5 mt-3">
                        <p class="text-gray-600 mb-2">
                            <i class="fas fa-id-card text-gray-400 mr-2 w-20px text-center"></i> 
                            <strong>Cédula Prof.:</strong> {{ $veterinario->cedula_profesional ?? 'No registrada' }}
                        </p>
                        <p class="text-gray-600 mb-0">
                            <i class="fas fa-envelope text-gray-400 mr-2 w-20px text-center"></i> 
                            <strong>Email:</strong> {{ Auth::user()->email }}
                        </p>
                    </div>

                    @if($veterinario->foto_firma)
                        <div class="mt-4 pt-3 border-top w-75 mx-auto">
                            <p class="small text-muted mb-2">Firma digital registrada:</p>
                            <img src="{{ asset('storage/' . $veterinario->foto_firma) }}" alt="Firma" class="img-fluid" style="max-height: 50px; opacity: 0.8;">
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Tarjeta de Accesos Rápidos -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-white border-bottom-success">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-bolt mr-2"></i>Accesos Rápidos</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">¿Qué te gustaría hacer a continuación?</p>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <a href="{{ route('expedientes.index') }}" class="btn btn-outline-primary btn-block p-3 shadow-sm text-left">
                                <i class="fas fa-search fa-2x mb-2 d-block text-center"></i>
                                <span class="d-block text-center font-weight-bold">Buscar Paciente</span>
                            </a>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <a href="#" class="btn btn-outline-success btn-block p-3 shadow-sm text-left">
                                <i class="fas fa-plus-circle fa-2x mb-2 d-block text-center"></i>
                                <span class="d-block text-center font-weight-bold">Nuevo Paciente</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection
