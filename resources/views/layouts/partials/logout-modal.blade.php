{{-- ============================================================
     PARTIAL: Modal de confirmación de Logout
     ============================================================ --}}
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">
                    <i class="fas fa-sign-out-alt mr-2"></i>¿Cerrar sesión?
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Selecciona <strong>"Salir"</strong> para terminar tu sesión actual.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger" href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt mr-1"></i> Salir
                </a>
            </div>
        </div>
    </div>
</div>
