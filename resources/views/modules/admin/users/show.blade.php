{{-- ============================================================
     Vista: Confirmar Eliminación de Usuario (Show)
     ============================================================ --}}
@extends('layouts.admin')

@section('titulo_pagina', 'Detalles del Usuario')

@section('contenido')

{{-- Encabezado --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-times mr-2 text-danger"></i>Eliminar Usuario
        </h1>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al listado
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        
        {{-- Alerta si hay dependencias --}}
        @if($hasDependencies)
        <div class="alert alert-warning shadow-sm border-left-warning mb-4">
            <h5 class="font-weight-bold mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Acción denegada</h5>
            <p class="mb-0">
                No puedes eliminar a este usuario porque contiene datos vinculados en el sistema.<br>
                <strong>Detalle:</strong> {{ $dependencyMessage }}
            </p>
            <hr>
            <p class="mb-0 small">Si ya no deseas que acceda al sistema, te recomendamos cambiar su estado a <strong>Inactivo</strong> desde la pantalla de edición.</p>
        </div>
        @else
        <div class="alert alert-danger shadow-sm border-left-danger mb-4">
            <h5 class="font-weight-bold mb-2"><i class="fas fa-exclamation-circle mr-2"></i>¡Advertencia de seguridad!</h5>
            <p class="mb-0">
                Estás a punto de eliminar permanentemente a este usuario. <strong>Esta acción no se puede deshacer.</strong>
            </p>
        </div>
        @endif

        {{-- Tarjeta de información --}}
        <div class="card shadow mb-4 {{ $hasDependencies ? 'border-warning' : 'border-danger' }}">
            <div class="card-header py-3 {{ $hasDependencies ? 'bg-warning text-dark' : 'bg-danger text-white' }}">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-id-card mr-2"></i>Información del registro
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td style="width: 35%" class="text-muted font-weight-bold text-right">ID:</td>
                        <td>#{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold text-right">Nombre Completo:</td>
                        <td class="font-weight-bold text-gray-800">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold text-right">Correo:</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold text-right">Rol:</td>
                        <td class="text-capitalize">{{ $user->role }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted font-weight-bold text-right">Fecha de registro:</td>
                        <td>{{ $user->created_at->format('d/m/Y H:i A') }}</td>
                    </tr>
                </table>

                <div class="text-center mt-4 pt-3 border-top">
                    @if($hasDependencies)
                        {{-- Botón a edición en lugar de eliminar --}}
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                            <i class="fas fa-edit mr-1"></i>Ir a Inactivar Usuario
                        </a>
                    @else
                        {{-- Formulario de eliminación --}}
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary mr-2">
                                <i class="fas fa-times mr-1"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt mr-1"></i>Sí, Eliminar Permanentemente
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
