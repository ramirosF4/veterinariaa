{{-- ============================================================
     Vista: Gestión de Usuarios — Rol Administrador
     Ruta: admin/users
     ============================================================ --}}
@extends('layouts.admin')

@section('titulo_pagina', 'Gestión de Usuarios')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users/index.css') }}">
@endpush

@section('contenido')

{{-- Encabezado de página --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users-cog mr-2 text-info"></i>Gestión de Usuarios
        </h1>
        <p class="mb-0 text-muted small mt-1">Administra los usuarios del sistema y sus roles.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-info btn-sm shadow-sm">
        <i class="fas fa-user-plus mr-1"></i> Nuevo Usuario
    </a>
</div>

{{-- Alertas de sesión --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

{{-- Tarjetas de estadísticas --}}
<div class="row mb-4">
    {{-- Total usuarios --}}
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Usuarios</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Administradores --}}
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Administradores</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAdmins }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Veterinarios --}}
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Veterinarios</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalVeterinarios }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-md fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Card principal: tabla de usuarios --}}
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h6 class="m-0 font-weight-bold text-info">
            <i class="fas fa-list mr-2"></i>Listado de Usuarios
        </h6>
    </div>
    <div class="card-body">

        {{-- Filtros y búsqueda --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-5 mb-2">
                    <div class="input-group search-bar">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search fa-sm"></i></span>
                        </div>
                        <input
                            type="text"
                            name="search"
                            class="form-control form-control-sm"
                            placeholder="Buscar por nombre o correo..."
                            value="{{ request('search') }}"
                        >
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <select name="role" class="form-control form-control-sm">
                        <option value="">— Todos los roles —</option>
                        <option value="administrador" {{ request('role') === 'administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="veterinario"   {{ request('role') === 'veterinario'   ? 'selected' : '' }}>Veterinario</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2 d-flex gap-2">
                    <button type="submit" class="btn btn-info btn-sm mr-2">
                        <i class="fas fa-filter mr-1"></i> Filtrar
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-times mr-1"></i> Limpiar
                    </a>
                </div>
            </div>
        </form>

        {{-- Tabla --}}
        <div class="table-responsive">
            <table class="table table-bordered table-users" id="tablaUsuarios">
                <thead>
                    <tr class="bg-light">
                        <th style="width:50px">#</th>
                        <th>Usuario</th>
                        <th>Correo Electrónico</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Registro</th>
                        <th style="width:100px" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="text-muted small">{{ $user->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="user-avatar mr-3 {{ $user->role === 'administrador' ? 'avatar-admin' : 'avatar-vet' }}">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                                <div>
                                    <div class="font-weight-bold text-gray-800">{{ $user->name }}</div>
                                    @if($user->id === auth()->id())
                                        <small class="text-success"><i class="fas fa-circle" style="font-size:0.5rem"></i> Tú</small>
                                    @endif
                                    @if($user->role === 'veterinario' && $user->veterinario)
                                        <div class="text-muted mt-1" style="font-size: 0.75rem;">
                                            @if($user->veterinario->especialidad)
                                                <i class="fas fa-star text-warning"></i> {{ $user->veterinario->especialidad }}
                                            @endif
                                            @if($user->veterinario->cedula_profesional)
                                                <span class="ml-1"><i class="fas fa-id-badge text-info"></i> {{ $user->veterinario->cedula_profesional }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-gray-600 small">{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'administrador')
                                <span class="badge badge-role badge-admin">
                                    <i class="fas fa-shield-alt mr-1"></i>Administrador
                                </span>
                            @else
                                <span class="badge badge-role badge-vet">
                                    <i class="fas fa-user-md mr-1"></i>Veterinario
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($user->activo)
                                <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i>Activo</span>
                            @else
                                <span class="badge badge-secondary"><i class="fas fa-minus-circle mr-1"></i>Inactivo</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            {{-- Editar --}}
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="btn btn-action btn-outline-info mr-1"
                               title="Editar usuario">
                                <i class="fas fa-edit"></i>
                            </a>
                            {{-- Eliminar (Lleva a la vista Show para confirmación) --}}
                            @if($user->id !== auth()->id())
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="btn btn-action btn-outline-danger"
                                   title="Eliminar usuario">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            @else
                                <button class="btn btn-action btn-outline-secondary" disabled title="No puedes eliminarte a ti mismo">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state text-center">
                                <i class="fas fa-users d-block"></i>
                                <p class="mb-2 font-weight-bold">No se encontraron usuarios</p>
                                <p class="small">Prueba cambiando los filtros o
                                    <a href="{{ route('admin.users.create') }}" class="text-info">crea uno nuevo</a>.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($users->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">
                Mostrando {{ $users->firstItem() }}–{{ $users->lastItem() }} de {{ $users->total() }} usuarios
            </small>
            {{ $users->links() }}
        </div>
        @endif

    </div>
</div>

@endsection
