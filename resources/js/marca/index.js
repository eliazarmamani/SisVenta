document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | SIMPLE DATATABLE
    |--------------------------------------------------------------------------
    */

    const tabla = document.querySelector('#datatablesSimple');

    if (tabla && typeof simpleDatatables !== 'undefined') {

        new simpleDatatables.DataTable(tabla, {

            perPage: 8,

            perPageSelect: [5, 8, 10, 15, 20],

            searchable: true,

            sortable: true,

            labels: {
                placeholder: 'Buscar marca...',
                perPage: 'registros por página',
                noRows: 'No hay marcas registradas',
                noResults: 'No se encontraron resultados',
                info: 'Mostrando {start} a {end} de {rows} marcas'
            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | NOTIFICACIONES
    |--------------------------------------------------------------------------
    */

    const notification = document.querySelector('#notification-data');

    if (notification && typeof Swal !== 'undefined') {

        const type = notification.dataset.type;
        const message = notification.dataset.message;

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: type,
            title: message,
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            background: '#ffffff',
            didOpen: function (toast) {

                toast.addEventListener(
                    'mouseenter',
                    Swal.stopTimer
                );

                toast.addEventListener(
                    'mouseleave',
                    Swal.resumeTimer
                );

            }
        });

    }


    /*
    |--------------------------------------------------------------------------
    | BOTÓN DE CONFIRMACIÓN
    |--------------------------------------------------------------------------
    */

    const formularios = document.querySelectorAll(
        '.confirmation-modal form'
    );

    formularios.forEach(function (formulario) {

        formulario.addEventListener('submit', function () {

            const boton = formulario.querySelector(
                'button[type="submit"]'
            );

            if (boton) {

                boton.disabled = true;

                boton.innerHTML = `
                    <span
                        class="spinner-border spinner-border-sm me-1"
                        role="status"
                        aria-hidden="true">
                    </span>
                    Procesando...
                `;

            }

        });

    });

});