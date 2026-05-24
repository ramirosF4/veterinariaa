@extends('layouts.main')

@section('titulo_pagina', 'Alergias de ' . $mascota->nombre)

@section('contenido')
    <!-- Migajas de Pan -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white border-left-primary shadow-sm rounded mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('expedientes.index') }}">Expedientes</a></li>
            <li class="breadcrumb-item"><a href="{{ route('expedientes.consultas', $mascota->id) }}">Consultas de {{ $mascota->nombre }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Alergias</li>
        </ol>
    </nav>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-allergies mr-2 text-danger"></i>Alergias y Reacciones
        </h1>
        @if(request('consulta_id'))
            <a href="{{ route('expedientes.consultas.ver', ['id' => $mascota->id, 'consulta_id' => request('consulta_id')]) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Volver a la Consulta
            </a>
        @else
            <a href="{{ route('expedientes.consultas', $mascota->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Volver a Consultas
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i> Por favor corrige los siguientes errores:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Formulario para agregar alergia -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-plus-circle mr-2"></i>Registrar Nueva Alergia
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('expedientes.alergias.guardar', $mascota->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="sustancia_alergena" class="font-weight-bold text-gray-700">Sustancia Alérgena <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="sustancia_alergena" name="sustancia_alergena" placeholder="Ej. Penicilina, Polen, Pollo" required value="{{ old('sustancia_alergena') }}">
                        </div>
                        <div class="form-group">
                            <label for="reaccion" class="font-weight-bold text-gray-700">Reacción Observada</label>
                            <input type="text" class="form-control" id="reaccion" name="reaccion" placeholder="Ej. Erupción cutánea, Vómito" value="{{ old('reaccion') }}">
                        </div>
                        <button type="submit" class="btn btn-danger btn-block shadow-sm">
                            <i class="fas fa-save mr-1"></i> Guardar Alergia
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lista de Alergias -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-clipboard-list mr-2"></i>Alergias Registradas
                    </h6>
                </div>
                <div class="card-body p-0">
                    @if($mascota->antecedenteAlergias && $mascota->antecedenteAlergias->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-gray-800 text-sm">
                                <thead class="bg-light text-gray-600">
                                    <tr>
                                        <th class="border-0">#</th>
                                        <th class="border-0">Sustancia Alérgena</th>
                                        <th class="border-0">Reacción</th>
                                        <th class="border-0">Fecha de Registro</th>
                                        <th class="border-0 text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mascota->antecedenteAlergias as $alergia)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle font-weight-bold text-danger">{{ $alergia->sustancia_alergena }}</td>
                                        <td class="align-middle">{{ $alergia->reaccion ?? '—' }}</td>
                                        <td class="align-middle">{{ $alergia->created_at ? $alergia->created_at->format('d/m/Y') : '—' }}</td>
                                        <td class="align-middle text-center">
                                            <form action="{{ route('expedientes.alergias.eliminar', ['id' => $mascota->id, 'alergia_id' => $alergia->id]) }}" method="POST" class="d-inline form-eliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm btn-eliminar" title="Eliminar Alergia">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <p class="text-gray-500 mb-0">Esta mascota no reporta alergias conocidas.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.form-eliminar');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if(confirm('¿Está seguro de que desea eliminar este registro de alergia? Esta acción no se puede deshacer.')) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush
