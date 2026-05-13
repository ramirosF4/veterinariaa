{{-- ============================================================
     Layout para autenticación (Login)
     Sin sidebar, sin topbar — fondo degradado primario
     ============================================================ --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Gestión Veterinaria - Login">
    <meta name="author" content="">

    <title>@yield('titulo_pagina', 'Iniciar Sesión') | Sistema Veterinario</title>

    {{-- Fonts --}}
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    {{-- SB Admin 2 CSS --}}
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    {{-- Estilos adicionales --}}
    @stack('styles')
</head>

{{-- Fondo degradado azul primario igual que la plantilla SB Admin 2 --}}
<body class="bg-gradient-primary">

    @yield('contenido')

    {{-- Bootstrap core JS --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    {{-- Core plugin JS --}}
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    {{-- SB Admin 2 scripts --}}
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    {{-- Scripts adicionales --}}
    @stack('scripts')

</body>

</html>
