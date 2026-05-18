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
            <h6 class="m-0 font-weight-bold text-primary">Gestión de Expedientes</h6>
        </div>
        <div class="card-body">
            <p>Aquí se mostrará el contenido de los expedientes.</p>
        </div>
    </div>
@endsection
