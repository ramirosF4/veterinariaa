{{-- ============================================================
     Layout principal - SB Admin 2
     Usado por todas las vistas autenticadas (dashboard, módulos)
     ============================================================ --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Gestión Veterinaria">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titulo_pagina', 'Veterinaria') | Sistema Veterinario</title>

    {{-- Fonts --}}
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    {{-- SB Admin 2 CSS --}}
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    {{-- Estilos adicionales por vista --}}
    @stack('styles')
</head>

<body id="page-top" class="@yield('body_class')">

    {{-- ===== PAGE WRAPPER ===== --}}
    <div id="wrapper">

        {{-- ===== SIDEBAR ===== --}}
        @unless(View::hasSection('hide_sidebar'))
            @include('layouts.partials.sidebar')
        @endunless
        {{-- ===== FIN SIDEBAR ===== --}}

        {{-- ===== CONTENT WRAPPER ===== --}}
        <div id="content-wrapper" class="d-flex flex-column">

            {{-- ===== MAIN CONTENT ===== --}}
            <div id="content">

                {{-- ===== TOPBAR (navbar superior) ===== --}}
                @include('layouts.partials.topbar')
                {{-- ===== FIN TOPBAR ===== --}}

                {{-- ===== CONTENIDO DE LA PÁGINA ===== --}}
                <div class="container-fluid">
                    @yield('contenido')
                </div>
                {{-- ===== FIN CONTENIDO ===== --}}

            </div>
            {{-- End of Main Content --}}

            {{-- ===== FOOTER ===== --}}
            @include('layouts.partials.footer')
            {{-- ===== FIN FOOTER ===== --}}

        </div>
        {{-- End of Content Wrapper --}}

    </div>
    {{-- End of Page Wrapper --}}

    {{-- Scroll to Top --}}
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- Modal de Logout --}}
    @include('layouts.partials.logout-modal')

    {{-- Bootstrap core JS --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    {{-- Core plugin JS --}}
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    {{-- SB Admin 2 scripts --}}
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    {{-- Scripts adicionales por vista --}}
    @stack('scripts')

</body>

</html>
