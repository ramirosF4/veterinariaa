@extends('layouts.main')

@section('hide_sidebar', true)

@section('titulo_pagina', 'Expedientes')

@section('contenido')
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
            
            {{-- Barra de Búsqueda --}}
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8 col-md-10">
                    <div class="input-group input-group-lg shadow-sm">
                        <input type="text" class="form-control" placeholder="Buscar paciente por nombre, ID o dueño..." aria-label="Buscar expediente">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4" type="button">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="row justify-content-center mt-4">
                <div class="col-12">
                    <button class="btn btn-info btn-icon-split btn-lg mx-2 mb-3 shadow-sm">
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
