{{-- ============================================================
     PARTIAL: Topbar (barra de navegación superior)
     Incluye: toggle sidebar, usuario logueado, logout
     ============================================================ --}}
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    {{-- Sidebar Toggle (Mobile) --}}
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    {{-- Enlaces de navegación superior --}}
    <ul class="navbar-nav mr-auto align-items-center">
        {{-- Pestaña: Inicio --}}
        <li class="nav-item mx-2 {{ request()->routeIs('home') ? 'active' : '' }}">
            <a class="nav-link text-lg" href="{{ route('home') }}" 
               style="color: {{ request()->routeIs('home') ? '#4e73df' : '#858796' }}; border-bottom: {{ request()->routeIs('home') ? '2px solid #4e73df' : 'none' }};">
                <i class="fas fa-home mr-1"></i>
                <span class="font-weight-bold">Inicio</span>
            </a>
        </li>

        {{-- Pestaña: Expedientes --}}
        <li class="nav-item mx-2 {{ request()->routeIs('expedientes.*') ? 'active' : '' }}">
            <a class="nav-link text-lg" href="{{ route('expedientes.index') }}" 
               style="color: {{ request()->routeIs('expedientes.*') ? '#4e73df' : '#858796' }}; border-bottom: {{ request()->routeIs('expedientes.*') ? '2px solid #4e73df' : 'none' }};">
                <i class="fas fa-folder-open mr-1"></i>
                <span class="font-weight-bold">Expedientes</span>
            </a>
        </li>
    </ul>
    {{-- Topbar Navbar --}}
    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        {{-- Nav Item - Usuario logueado --}}
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ Auth::user()->name ?? 'Usuario' }}
                </span>
                <i class="fas fa-user-circle fa-fw fa-lg text-gray-400"></i>
            </a>
            {{-- Dropdown - Información del usuario --}}
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Perfil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Cerrar sesión
                </a>
            </div>
        </li>

    </ul>

</nav>
