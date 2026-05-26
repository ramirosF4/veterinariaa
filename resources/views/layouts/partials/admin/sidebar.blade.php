{{-- ============================================================
     PARTIAL: Sidebar del Administrador
     Menú exclusivo para el rol 'administrador'
     Basado en SB Admin 2 — acordeón
     ============================================================ --}}
<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Sidebar Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
        @php
            $clinicLogo = \App\Models\Setting::where('key', 'clinic_logo')->value('value');
            $clinicName = \App\Models\Setting::where('key', 'clinic_name')->value('value') ?? 'Admin Panel';
        @endphp
        
        @if($clinicLogo)
            <div class="sidebar-brand-icon">
                <img src="{{ asset('storage/' . $clinicLogo) }}" alt="Logo" style="max-height: 40px; border-radius: 5px; max-width: 100%;">
            </div>
        @else
            <div class="sidebar-brand-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="sidebar-brand-text mx-3">{{ $clinicName }}</div>
        @endif
    </a>

    {{-- Divider --}}
    <hr class="sidebar-divider my-0">

    {{-- Nav Item - Dashboard Admin --}}
    <li class="nav-item {{ request()->routeIs('admin.home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- Heading --}}
    <div class="sidebar-heading">
        Gestión de Sistema
    </div>

    {{-- Nav Item - Usuarios --}}
    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('admin.users.*') ? '' : 'collapsed' }}"
            href="#" data-toggle="collapse" data-target="#collapseUsuarios"
            aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}"
            aria-controls="collapseUsuarios">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Usuarios</span>
        </a>
        <div id="collapseUsuarios"
             class="collapse {{ request()->routeIs('admin.users.*') ? 'show' : '' }}"
             aria-labelledby="headingUsuarios" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestión:</h6>
                <a class="collapse-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
                   href="{{ route('admin.users.index') }}">
                    <i class="fas fa-list fa-xs mr-1"></i>Ver todos
                </a>
                <a class="collapse-item {{ request()->routeIs('admin.users.create') ? 'active' : '' }}"
                   href="{{ route('admin.users.create') }}">
                    <i class="fas fa-user-plus fa-xs mr-1"></i>Nuevo usuario
                </a>
            </div>
        </div>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- Heading --}}
    <div class="sidebar-heading">
        Configuración
    </div>

    {{-- Nav Item - Configuración --}}
    <li class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.settings.index') }}">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Configuración</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggler --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
