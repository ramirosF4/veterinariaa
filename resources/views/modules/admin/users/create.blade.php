{{-- ============================================================
     Vista: Crear Usuario — Rol Administrador
     ============================================================ --}}
@extends('layouts.admin')

@section('titulo_pagina', 'Nuevo Usuario')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users/create.css') }}">
@endpush

@section('contenido')

{{-- Encabezado --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-plus mr-2 text-info"></i>Nuevo Usuario
        </h1>
        <p class="mb-0 text-muted small mt-1">
            <a href="{{ route('admin.users.index') }}" class="text-info">
                <i class="fas fa-arrow-left mr-1"></i>Volver al listado
            </a>
        </p>
    </div>
</div>

<div class="card shadow form-card mb-4">
    <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-id-card mr-2"></i>Información del Usuario
                </h6>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.users.store') }}" method="POST" id="formCrearUsuario">
                    @csrf

                    {{-- Nombre --}}
                    <div class="form-group">
                        <label for="name" class="form-label-custom">Nombre completo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user text-info"></i></span>
                            </div>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Nombre y apellido"
                                value="{{ old('name') }}"
                                autofocus
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email" class="form-label-custom">Correo electrónico</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope text-info"></i></span>
                            </div>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="correo@ejemplo.com"
                                value="{{ old('email') }}"
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Rol --}}
                    <div class="form-group">
                        <label class="form-label-custom">Rol del usuario</label>
                        @error('role')
                            <div class="text-danger small mb-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</div>
                        @enderror
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="role-option d-flex align-items-start {{ old('role') === 'administrador' ? 'selected' : '' }}" id="label-admin">
                                    <input type="radio" name="role" value="administrador" class="mr-3 mt-1 role-radio"
                                        {{ old('role') === 'administrador' ? 'checked' : '' }}>
                                    <div>
                                        <div class="font-weight-bold text-gray-800">
                                            <i class="fas fa-shield-alt text-info mr-1"></i>Administrador
                                        </div>
                                        <small class="text-muted">Acceso completo al sistema, gestión de usuarios y configuración.</small>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="role-option d-flex align-items-start {{ old('role') === 'veterinario' ? 'selected' : '' }}" id="label-vet">
                                    <input type="radio" name="role" value="veterinario" class="mr-3 mt-1 role-radio"
                                        {{ old('role') === 'veterinario' ? 'checked' : '' }}>
                                    <div>
                                        <div class="font-weight-bold text-gray-800">
                                            <i class="fas fa-user-md text-warning mr-1"></i>Veterinario
                                        </div>
                                        <small class="text-muted">Acceso a consultas, mascotas y fichas médicas.</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Campos adicionales de Veterinario (Ocultos por defecto) --}}
                    <div id="veterinario-fields" style="{{ old('role') === 'veterinario' ? '' : 'display: none;' }}">
                        <h6 class="font-weight-bold text-warning mb-3 mt-4 border-bottom pb-2">
                            <i class="fas fa-stethoscope mr-1"></i> Datos Profesionales (Solo Veterinarios)
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="especialidad" class="form-label-custom">Especialidad</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-star text-warning"></i></span>
                                        </div>
                                        <input type="text" name="especialidad" id="especialidad" 
                                               class="form-control @error('especialidad') is-invalid @enderror" 
                                               placeholder="Ej. Cirugía, Dermatología..." value="{{ old('especialidad') }}">
                                        @error('especialidad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cedula_profesional" class="form-label-custom">Cédula Profesional</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-badge text-warning"></i></span>
                                        </div>
                                        <input type="text" name="cedula_profesional" id="cedula_profesional" 
                                               class="form-control @error('cedula_profesional') is-invalid @enderror" 
                                               placeholder="Nº de Cédula" value="{{ old('cedula_profesional') }}">
                                        @error('cedula_profesional') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Contraseña --}}
                    <div class="form-group">
                        <label for="password" class="form-label-custom">Contraseña</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock text-info"></i></span>
                            </div>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Mínimo 8 caracteres"
                            >
                            <div class="input-group-append">
                                <span class="input-group-text password-toggle" onclick="togglePassword('password', this)">
                                    <i class="fas fa-eye text-muted"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label-custom">Confirmar Contraseña</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock text-info"></i></span>
                            </div>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control"
                                placeholder="Repite la contraseña"
                            >
                            <div class="input-group-append">
                                <span class="input-group-text password-toggle" onclick="togglePassword('password_confirmation', this)">
                                    <i class="fas fa-eye text-muted"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Acciones --}}
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary mr-2">
                            <i class="fas fa-times mr-1"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-save mr-1"></i>Guardar Usuario
                        </button>
                    </div>

                </form>
            </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/usuarios/create.js') }}"></script>
@endpush
