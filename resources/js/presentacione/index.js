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

            labels: {
                placeholder: 'Buscar presentación...',
                perPage: 'registros por página',
                noRows: 'No se encontraron presentaciones',
                noResults: 'No se encontraron resultados',
                info: 'Mostrando {start} a {end} de {rows} presentaciones'
            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | SWEETALERT - MENSAJE DE ÉXITO
    |--------------------------------------------------------------------------
    */

    const successMessage = document.querySelector(
        '#presentacion-success-message'
    );

    if (successMessage && typeof Swal !== 'undefined') {

        const Toast = Swal.mixin({

            toast: true,

            position: 'top-end',

            showConfirmButton: false,

            timer: 2500,

            timerProgressBar: true,

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

        Toast.fire({
            icon: 'success',
            title: successMessage.dataset.message
        });

    }


    /*
    |--------------------------------------------------------------------------
    | SWEETALERT - MENSAJE DE ERROR
    |--------------------------------------------------------------------------
    */

    const errorMessage = document.querySelector(
        '#presentacion-error-message'
    );

    if (errorMessage && typeof Swal !== 'undefined') {

        Swal.fire({

            toast: true,

            position: 'top-end',

            icon: 'error',

            title: errorMessage.dataset.message,

            showConfirmButton: false,

            timer: 3000,

            timerProgressBar: true

        });

    }


    /*
    |--------------------------------------------------------------------------
    | DESACTIVAR BOTÓN AL CONFIRMAR
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.confirmation-modal form'
    ).forEach(function (form) {

        form.addEventListener('submit', function () {

            const button = form.querySelector('.btn-confirm');

            if (!button) {
                return;
            }

            button.disabled = true;

            button.innerHTML = `
                <span
                    class="spinner-border spinner-border-sm me-1"
                    role="status"
                    aria-hidden="true">
                </span>
                Procesando...
            `;

        });

    });

});