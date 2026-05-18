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

    {{-- Divider --}}
    <hr class="sidebar-divider my-0">

    {{-- Nav Item - Dashboard --}}
    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

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

    {{-- Divider --}}
    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggler --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
