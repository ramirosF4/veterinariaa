{{-- ============================================================
     PARTIAL: Topbar del Administrador
     Incluye: toggle sidebar, badge de rol, usuario logueado, logout
     ============================================================ --}}
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    {{-- Sidebar Toggle (Mobile) --}}
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    {{-- Badge de rol visible en desktop --}}
    <span class="d-none d-sm-inline-flex align-items-center">
        <span class="badge badge-info px-3 py-2">
            <i class="fas fa-shield-alt mr-1"></i> Administrador
        </span>
    </span>

    {{-- Spacer --}}
    <div class="mr-auto"></div>

    {{-- Topbar Navbar --}}
    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        {{-- Nav Item - Usuario logueado --}}
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="adminUserDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ Auth::user()->name ?? 'Administrador' }}
                </span>
                <i class="fas fa-user-shield fa-fw fa-lg text-info"></i>
            </a>
            {{-- Dropdown - Información del administrador --}}
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="adminUserDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user-cog fa-sm fa-fw mr-2 text-gray-400"></i>
                    Mi perfil
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Configuración
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
