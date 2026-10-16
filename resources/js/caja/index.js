document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DataTable
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
                placeholder: 'Buscar caja...',
                perPage: 'Registros por página',
                noRows: 'No hay cajas registradas',
                noResults: 'No se encontraron resultados',
                info: 'Mostrando {start} a {end} de {rows} cajas'
            },

            columns: [
                {
                    select: 6,
                    sortable: false
                }
            ]
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Confirmación visual antes de cerrar una caja
    |--------------------------------------------------------------------------
    */

    const formulariosCerrar = document.querySelectorAll(
        '.btn-modal-confirmar'
    );

    formulariosCerrar.forEach(function (boton) {

        const formulario = boton.closest('form');

        if (!formulario) {
            return;
        }

        formulario.addEventListener('submit', function (event) {

            // Evita doble envío
            if (boton.disabled) {
                event.preventDefault();
                return;
            }

            // Bloquea el botón
            boton.disabled = true;

            boton.classList.add('is-loading');

            boton.innerHTML = `
                <i class="fa-solid fa-spinner fa-spin me-1"></i>
                Cerrando caja...
            `;
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Cerrar modal y restaurar botón
    |--------------------------------------------------------------------------
    */

    const modales = document.querySelectorAll('.modal');

    modales.forEach(function (modal) {

        modal.addEventListener('shown.bs.modal', function () {
            document.body.classList.add('caja-modal-open');
        });

        modal.addEventListener('hidden.bs.modal', function () {

            document.body.classList.remove('caja-modal-open');

            const boton = modal.querySelector('.btn-modal-confirmar');

            if (!boton) {
                return;
            }

            boton.disabled = false;
            boton.classList.remove('is-loading');

            boton.innerHTML = `
                <i class="fa-solid fa-lock me-1"></i>
                Confirmar cierre
            `;
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Animación suave de las filas
    |--------------------------------------------------------------------------
    */

    const filas = document.querySelectorAll(
        '.cajas-table tbody tr'
    );

    filas.forEach(function (fila, index) {

        fila.style.opacity = '0';
        fila.style.transform = 'translateY(5px)';

        setTimeout(function () {

            fila.style.transition =
                'opacity .25s ease, transform .25s ease';

            fila.style.opacity = '1';
            fila.style.transform = 'translateY(0)';

        }, 40 * index);
    });


    /*
    |--------------------------------------------------------------------------
    | Notificaciones
    |--------------------------------------------------------------------------
    */

    const cajaAlert = document.querySelector('#caja-alert');

    if (cajaAlert && typeof Swal !== 'undefined') {

        const type = cajaAlert.dataset.type;
        const message = cajaAlert.dataset.message;

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