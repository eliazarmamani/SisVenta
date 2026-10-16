document.addEventListener('DOMContentLoaded', function () {

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
                placeholder: 'Buscar usuario...',
                perPage: 'Registros por página',
                noRows: 'No hay usuarios registrados',
                noResults: 'No se encontraron resultados',
                info: 'Mostrando {start} a {end} de {rows} usuarios'
            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | MODALES
    |--------------------------------------------------------------------------
    */

    const modals = document.querySelectorAll('.user-modal');

    modals.forEach(function (modal) {

        modal.addEventListener('shown.bs.modal', function () {
            document.body.classList.add('user-modal-open');
        });

        modal.addEventListener('hidden.bs.modal', function () {
            document.body.classList.remove('user-modal-open');
        });

    });


    /*
    |--------------------------------------------------------------------------
    | BOTONES DE CONFIRMACIÓN
    |--------------------------------------------------------------------------
    */

    const forms = document.querySelectorAll('.user-modal form');

    forms.forEach(function (form) {

        form.addEventListener('submit', function () {

            const button = form.querySelector('button[type="submit"]');

            if (!button) {
                return;
            }

            button.disabled = true;

            button.innerHTML = `
                <i class="fa-solid fa-spinner fa-spin me-1"></i>
                Procesando...
            `;

        });

    });


    /*
    |--------------------------------------------------------------------------
    | NOTIFICACIONES
    |--------------------------------------------------------------------------
    */

    const userAlert = document.querySelector('#user-alert');

    if (userAlert && typeof Swal !== 'undefined') {

        const type = userAlert.dataset.type;
        const message = userAlert.dataset.message;

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