document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    
    // Obtenemos la URL desde el atributo de datos (data-url) en el input
    const searchUrl = searchInput.dataset.url;
    let debounceTimer;

    // Ocultar al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length < 1) {
            searchResults.style.display = 'none';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`${searchUrl}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    
                    if (data.length === 0) {
                        searchResults.innerHTML = '<span class="dropdown-item text-muted disabled py-2">No se encontraron mascotas ni dueños...</span>';
                    } else {
                        data.forEach(item => {
                            const dueno = item.dueno ? item.dueno.nombre_completo : 'Sin dueño asignado';
                            const html = `
                                <a href="#" class="dropdown-item py-2 border-bottom result-item" data-id="${item.id}" data-nombre="${item.nombre}">
                                    <div class="font-weight-bold text-gray-800">
                                        <i class="fas fa-paw text-primary mr-1"></i> ${item.nombre}
                                        <span class="badge badge-info ml-1">Folio: ${item.id}</span>
                                    </div>
                                    <div class="small text-gray-600 mt-1">
                                        <i class="fas fa-user mr-1"></i> Dueño: ${dueno}
                                    </div>
                                </a>
                            `;
                            searchResults.insertAdjacentHTML('beforeend', html);
                        });

                        // Agregar evento click a los resultados generados
                        document.querySelectorAll('.result-item').forEach(el => {
                            el.addEventListener('click', function(e) {
                                e.preventDefault();
                                searchInput.value = this.getAttribute('data-nombre');
                                searchResults.style.display = 'none';
                                // Aquí puedes disparar una acción para cargar el expediente
                                console.log('Folio seleccionado:', this.getAttribute('data-id'));
                            });
                        });
                    }
                    
                    searchResults.style.display = 'block';
                })
                .catch(error => console.error('Error:', error));
        }, 300); // 300ms de retraso (Debounce)
    });
});
