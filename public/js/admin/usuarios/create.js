document.addEventListener('DOMContentLoaded', function() {
    // Highlight de tarjetas de rol y mostrar/ocultar campos de veterinario
    document.querySelectorAll('.role-radio').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.role-option').forEach(el => el.classList.remove('selected'));
            this.closest('.role-option').classList.add('selected');
            
            // Mostrar u ocultar sección de veterinario
            const vetFields = document.getElementById('veterinario-fields');
            if (vetFields) {
                if(this.value === 'veterinario') {
                    vetFields.style.display = 'block';
                    // Añadimos una pequeña animación
                    vetFields.style.animation = 'fadeIn 0.5s ease';
                } else {
                    vetFields.style.display = 'none';
                }
            }
        });
    });
});

// Toggle visibilidad de contraseña
function togglePassword(fieldId, btn) {
    var field = document.getElementById(fieldId);
    var icon = btn.querySelector('i');
    if (field && icon) {
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
}
