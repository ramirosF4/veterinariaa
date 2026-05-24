document.addEventListener('DOMContentLoaded', function() {
    // Confirmación genérica para botones de eliminación
    const deleteForms = document.querySelectorAll('.form-eliminar');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const confirmMessage = this.getAttribute('data-confirm') || '¿Está seguro de que desea eliminar este registro? Esta acción no se puede deshacer.';
            if(confirm(confirmMessage)) {
                this.submit();
            }
        });
    });

    // Actualizar label de input file (Bootstrap custom-file)
    const fileInputs = document.querySelectorAll('.custom-file-input');
    fileInputs.forEach(fileInput => {
        fileInput.addEventListener('change', function(e) {
            let fileName = 'Seleccionar archivo...';
            if (e.target.files.length > 0) {
                fileName = e.target.files[0].name;
            }
            const label = e.target.nextElementSibling;
            if(label && label.classList.contains('custom-file-label')) {
                const icon = label.querySelector('i');
                label.innerHTML = '';
                if(icon) {
                    label.appendChild(icon);
                    label.appendChild(document.createTextNode(' ' + fileName));
                } else {
                    label.innerText = fileName;
                }
            }
        });
    });
});
