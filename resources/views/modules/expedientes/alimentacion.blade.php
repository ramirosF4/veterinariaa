@extends('layouts.main')

@section('titulo_pagina', 'Historial de Alimentación de ' . $mascota->nombre)

@section('contenido')
    <!-- Migajas de Pan -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white border-left-success shadow-sm rounded mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('expedientes.index') }}">Expedientes</a></li>
            <li class="breadcrumb-item"><a href="{{ route('expedientes.consultas', $mascota->id) }}">Consultas de {{ $mascota->nombre }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Alimentación</li>
        </ol>
    </nav>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-bone mr-2 text-success"></i>Historial de Alimentación
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
        <!-- Formulario para agregar alimentación -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-plus-circle mr-2"></i>Registrar Dieta
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('expedientes.alimentacion.guardar', $mascota->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tipo_alimento" class="font-weight-bold text-gray-700">Tipo de Alimento <span class="text-danger">*</span></label>
                            <select class="form-control" id="tipo_alimento" name="tipo_alimento" required>
                                <option value="">Seleccionar...</option>
                                <option value="Croquetas (Seco)" {{ old('tipo_alimento') == 'Croquetas (Seco)' ? 'selected' : '' }}>Croquetas (Seco)</option>
                                <option value="Comida Húmeda (Latas/Sobres)" {{ old('tipo_alimento') == 'Comida Húmeda (Latas/Sobres)' ? 'selected' : '' }}>Comida Húmeda (Latas/Sobres)</option>
                                <option value="Dieta BARF (Cruda)" {{ old('tipo_alimento') == 'Dieta BARF (Cruda)' ? 'selected' : '' }}>Dieta BARF (Cruda)</option>
                                <option value="Dieta Casera Cocinada" {{ old('tipo_alimento') == 'Dieta Casera Cocinada' ? 'selected' : '' }}>Dieta Casera Cocinada</option>
                                <option value="Mixta" {{ old('tipo_alimento') == 'Mixta' ? 'selected' : '' }}>Mixta</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="marca_producto" class="font-weight-bold text-gray-700">Marca / Producto</label>
                            <input type="text" class="form-control" id="marca_producto" name="marca_producto" placeholder="Ej. Royal Canin, Pro Plan" value="{{ old('marca_producto') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="frecuencia_diaria" class="font-weight-bold text-gray-700">Veces al día <span class="text-danger">*</span></label>
                                    <input type="number" min="1" class="form-control" id="frecuencia_diaria" name="frecuencia_diaria" placeholder="Ej. 2" required value="{{ old('frecuencia_diaria') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cantidad_porcion" class="font-weight-bold text-gray-700">Porción</label>
                                    <input type="text" class="form-control" id="cantidad_porcion" name="cantidad_porcion" placeholder="Ej. 200g, 1 taza" value="{{ old('cantidad_porcion') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="descripcion_dieta" class="font-weight-bold text-gray-700">Descripción principal <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="descripcion_dieta" name="descripcion_dieta" rows="2" placeholder="Ej. Alimento premium para adulto raza pequeña..." required>{{ old('descripcion_dieta') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="observaciones" class="font-weight-bold text-gray-700">Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="2" placeholder="Ej. Mezclar con agua tibia, evitar darle pollo...">{{ old('observaciones') }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-block shadow-sm mt-4 font-weight-bold">
                            <i class="fas fa-save mr-1"></i> Guardar Dieta
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lista de Historial -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-clipboard-list mr-2"></i>Línea de Tiempo de Alimentación
                    </h6>
                </div>
                <div class="card-body p-0">
                    @if($mascota->historialAlimentaciones && $mascota->historialAlimentaciones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-gray-800 text-sm">
                                <thead class="bg-light text-gray-600">
                                    <tr>
                                        <th class="border-0">Estado</th>
                                        <th class="border-0">Tipo / Marca</th>
                                        <th class="border-0">Detalles</th>
                                        <th class="border-0">Frecuencia / Porción</th>
                                        <th class="border-0">Registro</th>
                                        <th class="border-0 text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mascota->historialAlimentaciones as $alimentacion)
                                    <tr>
                                        <td class="align-middle">
                                            @if($loop->first)
                                                <span class="badge badge-success shadow-sm p-2"><i class="fas fa-star mr-1"></i>Dieta Actual</span>
                                            @else
                                                <span class="badge badge-secondary shadow-sm p-2">Dieta Pasada</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <strong>{{ $alimentacion->tipo_alimento }}</strong>
                                            @if($alimentacion->marca_producto)
                                                <br><span class="text-muted small">{{ $alimentacion->marca_producto }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $alimentacion->descripcion_dieta }}">
                                                {{ $alimentacion->descripcion_dieta }}
                                            </span>
                                            @if($alimentacion->observaciones)
                                                <br><small class="text-info" title="{{ $alimentacion->observaciones }}"><i class="fas fa-info-circle mr-1"></i>Con observaciones</small>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <span class="font-weight-bold">{{ $alimentacion->frecuencia_diaria }} veces al día</span>
                                            @if($alimentacion->cantidad_porcion)
                                                <br><small class="text-muted">({{ $alimentacion->cantidad_porcion }} por vez)</small>
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ $alimentacion->created_at ? $alimentacion->created_at->format('d/m/Y') : '—' }}</td>
                                        <td class="align-middle text-center">
                                            <form action="{{ route('expedientes.alimentacion.eliminar', ['id' => $mascota->id, 'alimentacion_id' => $alimentacion->id]) }}" method="POST" class="d-inline form-eliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm btn-eliminar" title="Eliminar Registro">
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
                            <i class="fas fa-utensils fa-3x text-success mb-3"></i>
                            <p class="text-gray-500 mb-0">Esta mascota no tiene un historial de alimentación registrado.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


