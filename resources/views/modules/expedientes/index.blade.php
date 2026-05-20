@extends('layouts.main')

@section('hide_sidebar', true)

@section('titulo_pagina', 'Expedientes')

@push('styles')
    <link href="{{ asset('css/expedientes-custom.css') }}" rel="stylesheet">
@endpush

@section('contenido')
    <!-- Migajas de Pan -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white border-left-primary shadow-sm rounded mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Expedientes</li>
        </ol>
    </nav>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-folder-open mr-2"></i>Expedientes
        </h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Búsqueda de Expedientes</h6>
        </div>
        <div class="card-body text-center py-5">
            
            {{-- Barra de Búsqueda con Dropdown --}}
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8 col-md-10 position-relative">
                    <input type="text" id="searchInput" class="form-control form-control-lg shadow-sm" placeholder="Buscar paciente por nombre, ID o dueño..." aria-label="Buscar expediente" autocomplete="off" data-url="{{ route('expedientes.buscar') }}">
                    
                    {{-- Contenedor de Sugerencias --}}
                    <div id="searchResults" class="dropdown-menu w-100 shadow mt-1 dropdown-search-results" style="display: none;">
                        <!-- Los resultados de búsqueda se inyectarán aquí mediante JS -->
                    </div>
                </div>
            </div>

            {{-- Tarjeta de previsualización (Oculta por defecto) --}}
            <div class="row justify-content-center mb-4" id="previewContainer" style="display: none;">
                <div class="col-lg-8 col-md-10">
                    <div class="card shadow-sm border-left-info text-left">
                        <div class="card-body py-3">
                            <div class="row align-items-center">
                                <div class="col-md-6 border-right">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-2">Paciente Seleccionado</div>
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-paw fa-3x text-info mr-3"></i>
                                        <div>
                                            <h4 id="previewNombre" class="h5 mb-0 font-weight-bold text-gray-800"></h4>
                                            <div id="previewDetalles" class="text-xs text-gray-500 mt-1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pl-md-4 mt-3 mt-md-0">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-2">Dueño</div>
                                    <div class="text-sm font-weight-bold text-gray-800 mb-1">
                                        <i class="fas fa-user text-gray-500 mr-1"></i> <span id="previewDueno"></span>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        <i class="fas fa-phone mr-1"></i> <span id="previewTelefono"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="row justify-content-center mt-4">
                <div class="col-12">
                    <input type="hidden" id="selectedMascotaId" value="">
                    <button id="btnVerConsultas" class="btn btn-info btn-icon-split btn-lg mx-2 mb-3 shadow-sm" data-base-url="{{ url('expedientes') }}" disabled>
                        <span class="icon text-white-50">
                            <i class="fas fa-stethoscope"></i>
                        </span>
                        <span class="text">Ver Consultas</span>
                    </button>
                    
                    <button class="btn btn-success btn-icon-split btn-lg mx-2 mb-3 shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Crear Nuevo Paciente</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/expedientes.js') }}"></script>
@endpush
