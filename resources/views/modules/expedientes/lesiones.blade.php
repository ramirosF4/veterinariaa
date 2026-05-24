@extends('layouts.main')

@section('titulo_pagina', 'Lesiones Previas de ' . $mascota->nombre)

@section('contenido')
    <!-- Migajas de Pan -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-white border-left-warning shadow-sm rounded mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('expedientes.index') }}">Expedientes</a></li>
            <li class="breadcrumb-item"><a href="{{ route('expedientes.consultas', $mascota->id) }}">Consultas de {{ $mascota->nombre }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lesiones Previas</li>
        </ol>
    </nav>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-band-aid mr-2 text-warning"></i>Lesiones Previas
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
        <!-- Formulario para agregar lesion -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-plus-circle mr-2"></i>Registrar Lesión
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('expedientes.lesiones.guardar', $mascota->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="tipo_lesion" class="font-weight-bold text-gray-700">Tipo de Lesión <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tipo_lesion" name="tipo_lesion" placeholder="Ej. Fractura, Mordedura, Quemadura" required value="{{ old('tipo_lesion') }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="ubicacion" class="font-weight-bold text-gray-700">Ubicación <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ej. Pata delantera derecha" required value="{{ old('ubicacion') }}">
                        </div>

                        <div class="form-group">
                            <label for="gravedad" class="font-weight-bold text-gray-700">Gravedad</label>
                            <select class="form-control" id="gravedad" name="gravedad">
                                <option value="">Seleccionar...</option>
                                <option value="Leve" {{ old('gravedad') == 'Leve' ? 'selected' : '' }}>Leve</option>
                                <option value="Moderada" {{ old('gravedad') == 'Moderada' ? 'selected' : '' }}>Moderada</option>
                                <option value="Grave" {{ old('gravedad') == 'Grave' ? 'selected' : '' }}>Grave</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="fecha_lesion" class="font-weight-bold text-gray-700">Fecha de la Lesión</label>
                            <input type="date" class="form-control" id="fecha_lesion" name="fecha_lesion" value="{{ old('fecha_lesion') }}">
                        </div>

                        <div class="form-group">
                            <label for="descripcion" class="font-weight-bold text-gray-700">Observaciones</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Detalles adicionales...">{{ old('descripcion') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="imagen" class="font-weight-bold text-gray-700">Imagen de Respaldo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="imagen" name="imagen" accept="image/*">
                                <label class="custom-file-label border-warning shadow-sm" for="imagen" data-browse="Explorar">
                                    <i class="fas fa-upload mr-1 text-warning"></i> Seleccionar imagen...
                                </label>
                            </div>
                            <small class="form-text text-muted mt-2">Formatos: JPG, PNG, GIF (Máx. 2MB)</small>
                        </div>
                        
                        <button type="submit" class="btn btn-warning btn-block shadow-sm mt-4 text-dark font-weight-bold">
                            <i class="fas fa-save mr-1"></i> Guardar Lesión
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lista de Lesiones Previas -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-clipboard-list mr-2"></i>Historial de Lesiones
                    </h6>
                </div>
                <div class="card-body p-0">
                    @if($mascota->antecedenteLesiones && $mascota->antecedenteLesiones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-gray-800 text-sm">
                                <thead class="bg-light text-gray-600">
                                    <tr>
                                        <th class="border-0">#</th>
                                        <th class="border-0">Lesión</th>
                                        <th class="border-0">Ubicación</th>
                                        <th class="border-0">Gravedad</th>
                                        <th class="border-0">Fecha</th>
                                        <th class="border-0 text-center">Imagen</th>
                                        <th class="border-0 text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mascota->antecedenteLesiones as $lesion)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle font-weight-bold text-warning">{{ $lesion->tipo_lesion }}</td>
                                        <td class="align-middle">{{ $lesion->ubicacion }}</td>
                                        <td class="align-middle">
                                            @if($lesion->gravedad == 'Grave')
                                                <span class="badge badge-danger shadow-sm">{{ $lesion->gravedad }}</span>
                                            @elseif($lesion->gravedad == 'Moderada')
                                                <span class="badge badge-warning shadow-sm">{{ $lesion->gravedad }}</span>
                                            @elseif($lesion->gravedad == 'Leve')
                                                <span class="badge badge-info shadow-sm">{{ $lesion->gravedad }}</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ $lesion->fecha_lesion ? \Carbon\Carbon::parse($lesion->fecha_lesion)->format('d/m/Y') : '—' }}</td>
                                        <td class="align-middle text-center">
                                            @if($lesion->imagen_path)
                                                <a href="{{ asset('storage/' . $lesion->imagen_path) }}" target="_blank" class="btn btn-sm btn-info shadow-sm" title="Ver Imagen">
                                                    <i class="fas fa-image"></i>
                                                </a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <form action="{{ route('expedientes.lesiones.eliminar', ['id' => $mascota->id, 'lesion_id' => $lesion->id]) }}" method="POST" class="d-inline form-eliminar">
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
                            <i class="fas fa-bone fa-3x text-success mb-3"></i>
                            <p class="text-gray-500 mb-0">Esta mascota no tiene lesiones previas registradas.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


