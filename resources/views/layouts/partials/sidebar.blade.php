{{-- ============================================================
     PARTIAL: Sidebar de navegación lateral
     Basado en SB Admin 2 — acordeón con menú veterinaria
     ============================================================ --}}
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion @yield('sidebar_class')" id="accordionSidebar">

    {{-- Sidebar Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-paw"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Veterinaria</div>
    </a>

    @if(request()->routeIs(['expedientes.consultas.ver', 'expedientes.consultas.diagnostico', 'expedientes.consultas.tratamiento', 'expedientes.alergias', 'expedientes.patologicos', 'expedientes.lesiones']))
        
        {{-- Divider --}}
        <hr class="sidebar-divider">

        @php
            $currentConsultaId = request()->route('consulta_id') ?? request('consulta_id');
        @endphp

        @if($currentConsultaId)
            {{-- Heading --}}
            <div class="sidebar-heading">
                Detalles de Consulta
            </div>

            {{-- Nav Item - Diagnóstico --}}
            <li class="nav-item {{ request()->routeIs('expedientes.consultas.diagnostico') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('expedientes.consultas.diagnostico', ['id' => request()->route('id'), 'consulta_id' => $currentConsultaId]) }}">
                    <i class="fas fa-fw fa-stethoscope"></i>
                    <span>Diagnóstico</span>
                </a>
            </li>

            {{-- Nav Item - Tratamiento --}}
            <li class="nav-item {{ request()->routeIs('expedientes.consultas.tratamiento') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('expedientes.consultas.tratamiento', ['id' => request()->route('id'), 'consulta_id' => $currentConsultaId]) }}">
                    <i class="fas fa-fw fa-pills"></i>
                    <span>Tratamiento</span>
                </a>
            </li>

            {{-- Divider --}}
            <hr class="sidebar-divider">
        @endif

        {{-- Heading --}}
        <div class="sidebar-heading">
            Antecedentes Médicos
        </div>

        {{-- Nav Item - Alergias --}}
        <li class="nav-item {{ request()->routeIs('expedientes.alergias') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('expedientes.alergias', ['id' => request()->route('id'), 'consulta_id' => $currentConsultaId ?? null]) }}">
                <i class="fas fa-fw fa-allergies"></i>
                <span>Alergias</span>
            </a>
        </li>

        {{-- Nav Item - Lesiones --}}
        <li class="nav-item {{ request()->routeIs('expedientes.lesiones') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('expedientes.lesiones', ['id' => request()->route('id'), 'consulta_id' => $currentConsultaId ?? null]) }}">
                <i class="fas fa-fw fa-band-aid"></i>
                <span>Lesiones Previas</span>
            </a>
        </li>

        {{-- Nav Item - Patológicos --}}
        <li class="nav-item {{ request()->routeIs('expedientes.patologicos') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('expedientes.patologicos', ['id' => request()->route('id'), 'consulta_id' => $currentConsultaId ?? null]) }}">
                <i class="fas fa-fw fa-virus"></i>
                <span>Patológicos</span>
            </a>
        </li>

        {{-- Divider --}}
        <hr class="sidebar-divider">

        {{-- Heading --}}
        <div class="sidebar-heading">
            Historial
        </div>

        {{-- Nav Item - Alimentación --}}
        <li class="nav-item">
            <a class="nav-link" href="#historial_alimentacion">
                <i class="fas fa-fw fa-bone"></i>
                <span>- Alimentación</span>
            </a>
        </li>

    @else
        {{-- Divider --}}
        <hr class="sidebar-divider">

        {{-- Heading --}}
        <div class="sidebar-heading">
            Gestión
        </div>

        {{-- Nav Item - Pacientes --}}
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="collapsePacientes"
                aria-expanded="true" aria-controls="collapsePacientes">
                <i class="fas fa-fw fa-dog"></i>
                <span>Pacientes</span>
            </a>
            <div id="collapsePacientes" class="collapse" aria-labelledby="headingPacientes" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Mascotas:</h6>
                    <a class="collapse-item" href="#">Ver todos</a>
                    <a class="collapse-item" href="#">Nuevo paciente</a>
                </div>
            </div>
        </li>

        {{-- Nav Item - Consultas --}}
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseConsultas"
                aria-expanded="true" aria-controls="collapseConsultas">
                <i class="fas fa-fw fa-stethoscope"></i>
                <span>Consultas</span>
            </a>
            <div id="collapseConsultas" class="collapse" aria-labelledby="headingConsultas" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Citas:</h6>
                    <a class="collapse-item" href="#">Ver consultas</a>
                    <a class="collapse-item" href="#">Nueva cita</a>
                </div>
            </div>
        </li>

        {{-- Nav Item - Propietarios --}}
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-users"></i>
                <span>Propietarios</span>
            </a>
        </li>

        {{-- Divider --}}
        <hr class="sidebar-divider">

        {{-- Heading --}}
        <div class="sidebar-heading">
            Sistema
        </div>

        {{-- Nav Item - Inventario --}}
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-boxes"></i>
                <span>Inventario</span>
            </a>
        </li>

        {{-- Nav Item - Reportes --}}
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-chart-bar"></i>
                <span>Reportes</span>
            </a>
        </li>
    @endif

    {{-- Divider --}}
    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggler --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
