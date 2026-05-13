{{-- Login — usa el layout de autenticación (sin sidebar) --}}
@extends('layouts.auth')

@section('titulo_pagina', 'Iniciar Sesión')

@section('contenido')
<div class="container">

    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">

                    <div class="row">
                        {{-- Columna imagen (visible solo en pantallas grandes) --}}
                        <div class="col-lg-6 d-none d-lg-block bg-gradient-primary d-flex flex-column align-items-center justify-content-center p-5" style="min-height: 400px;">
                            <img src="{{ asset('img/undraw_posting_photo.svg') }}"
                                 alt="Sistema Veterinario"
                                 class="img-fluid mb-4"
                                 style="max-width: 260px;">
                            <h2 class="text-white font-weight-bold text-center mb-2">
                                <i class="fas fa-paw mr-2"></i>Sistema Veterinario
                            </h2>
                            <p class="text-white-50 text-center small mb-0">
                                Gestión integral de pacientes y consultas
                            </p>
                        </div>

                        {{-- Columna formulario --}}
                        <div class="col-lg-6">
                            <div class="p-5">

                                <div class="text-center mb-4">
                                    <h1 class="h4 text-gray-900">¡Bienvenido!</h1>
                                    <p class="text-muted small">Inicia sesión para continuar</p>
                                </div>

                                {{-- Mensajes de error --}}
                                @if (session('error') || $errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        {{ session('error') ?? 'Credenciales incorrectas. Intenta de nuevo.' }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <form class="user" action="{{ route('logear') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <input type="text"
                                               class="form-control form-control-user @error('email') is-invalid @enderror"
                                               id="email"
                                               name="email"
                                               value="{{ old('email') }}"
                                               placeholder="Usuario o correo electrónico"
                                               autofocus
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password"
                                               class="form-control form-control-user @error('password') is-invalid @enderror"
                                               id="password"
                                               name="password"
                                               placeholder="Contraseña"
                                               required>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        <i class="fas fa-sign-in-alt mr-1"></i> Iniciar Sesión
                                    </button>

                                </form>

                                <hr>

                                <div class="text-center">
                                    <small class="text-muted">
                                        <i class="fas fa-lock mr-1"></i>
                                        Acceso restringido al personal autorizado
                                    </small>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
