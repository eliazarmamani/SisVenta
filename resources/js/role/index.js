document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | DATATABLE
    |--------------------------------------------------------------------------
    */

    const table = document.querySelector('#datatablesSimple');

    if (table && typeof simpleDatatables !== 'undefined') {

        new simpleDatatables.DataTable(table, {

            perPage: 8,

            perPageSelect: [5, 8, 10, 15, 20],

            searchable: true,

            sortable: true,

            labels: {
                placeholder: 'Buscar rol...',
                perPage: 'Registros por página',
                noRows: 'No hay roles registrados',
                noResults: 'No se encontraron resultados',
                info: 'Mostrando {start} a {end} de {rows} roles'
            },

            columns: [
                {
                    select: 3,
                    sortable: false
                }
            ]

        });

    }


    /*
    |--------------------------------------------------------------------------
    | LIMPIAR MODAL AL CERRAR
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.role-delete-modal').forEach(modal => {

        modal.addEventListener('hidden.bs.modal', () => {

            const confirmButton =
                modal.querySelector('.btn-delete-confirm');

            if (confirmButton) {

                confirmButton.classList.remove('is-loading');

                confirmButton.disabled = false;

                confirmButton.innerHTML = `
                    <i class="fa-solid fa-trash-can"></i>
                    Eliminar rol
                `;

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | CONFIRMACIÓN VISUAL AL ELIMINAR
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.btn-delete-confirm').forEach(button => {

        const form = button.closest('form');

        if (!form) {
            return;
        }

        form.addEventListener('submit', () => {

            button.disabled = true;

            button.classList.add('is-loading');

            button.innerHTML = `
                <i class="fa-solid fa-spinner fa-spin"></i>
                Eliminando...
            `;

        });

    });


    /*
    |--------------------------------------------------------------------------
    | ANIMACIÓN SUAVE DE LAS FILAS
    |--------------------------------------------------------------------------
    */

    const rows = document.querySelectorAll('.role-table tbody tr');

    rows.forEach((row, index) => {

        row.style.animationDelay = `${index * 35}ms`;

    });


    /*
    |--------------------------------------------------------------------------
    | NOTIFICACIONES
    |--------------------------------------------------------------------------
    */

    const roleAlert = document.querySelector('#role-alert');

    if (roleAlert && typeof Swal !== 'undefined') {

        const type = roleAlert.dataset.type;

        const message = roleAlert.dataset.message;


        if (type === 'success') {

            Swal.fire({
                icon: 'success',
                title: '¡Operación exitosa!',
                text: message,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#2563eb',
                timer: 3000,
                timerProgressBar: true,
                allowOutsideClick: false
            });

        }


        if (type === 'error') {

            Swal.fire({
                icon: 'error',
                title: 'No se pudo completar',
                text: message,
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#dc2626',
                allowOutsideClick: false
            });

        }

    }

});