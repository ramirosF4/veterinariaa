{{-- Dashboard del Administrador — usa el layout de administrador --}}
@extends('layouts.admin')

@section('titulo_pagina', 'Panel Administrador')

@section('contenido')

    {{-- Encabezado de página --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-shield-alt mr-2 text-info"></i>Panel de Administración
        </h1>
        <span class="text-muted small">
            <i class="fas fa-clock mr-1"></i>
            Bienvenido, {{ Auth::user()->name ?? 'Administrador' }}
        </span>
    </div>

    {{-- Alerta de rol --}}
    <div class="alert alert-info alert-dismissible fade show shadow-sm mb-4" role="alert">
        <i class="fas fa-shield-alt mr-2"></i>
        <strong>Sesión de Administrador activa.</strong> Tienes acceso completo al sistema.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    {{-- Tarjetas de resumen --}}
    <div class="row">

        {{-- Card - Total Usuarios --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Usuarios</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">—</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card - Veterinarios activos --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Veterinarios</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">—</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card - Consultas del sistema --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Consultas totales</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">—</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card - Reportes generados --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Reportes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">—</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Sección de accesos rápidos --}}
    <div class="row">

        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-users-cog mr-2"></i>Gestión de Usuarios
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-gray-600 mb-3">Administra los usuarios del sistema, asigna roles y gestiona permisos.</p>
                    <a href="#" class="btn btn-info btn-sm">
                        <i class="fas fa-users mr-1"></i> Ver Usuarios
                    </a>
                    <a href="#" class="btn btn-outline-info btn-sm ml-2">
                        <i class="fas fa-user-plus mr-1"></i> Nuevo Usuario
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-chart-line mr-2"></i>Reportes del Sistema
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-gray-600 mb-3">Consulta estadísticas globales, actividad de veterinarios y métricas del sistema.</p>
                    <a href="#" class="btn btn-info btn-sm">
                        <i class="fas fa-chart-bar mr-1"></i> Ver Reportes
                    </a>
                    <a href="#" class="btn btn-outline-info btn-sm ml-2">
                        <i class="fas fa-download mr-1"></i> Exportar
                    </a>
                </div>
            </div>
        </div>

    </div>

@endsection
