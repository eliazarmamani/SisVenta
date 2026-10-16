document.addEventListener('DOMContentLoaded', function () {
/*
|--------------------------------------------------------------------------
| DataTable
|--------------------------------------------------------------------------
*/

const tabla = document.querySelector('#datatablesSimple');

if (tabla && typeof simpleDatatables !== 'undefined') {

    new simpleDatatables.DataTable(tabla, {
        perPage: 8,
        perPageSelect: [5, 8, 10, 15, 20],

        labels: {
            placeholder: 'Buscar categoría...',
            perPage: 'registros por página',
            noRows: 'No hay categorías registradas',
            noResults: 'No se encontraron categorías',
            info: 'Mostrando {start} a {end} de {rows} categorías'
        }
    });

}


/*
|--------------------------------------------------------------------------
| Notificaciones
|--------------------------------------------------------------------------
*/

function mostrarNotificacion(elemento, tipo, titulo, tiempo) {

    if (!elemento || typeof Swal === 'undefined') {
        return;
    }

    const mensaje = elemento.dataset.message;

    if (!mensaje) {
        return;
    }

    Swal.fire({
        icon: tipo,
        title: titulo,
        text: mensaje,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: tiempo,
        timerProgressBar: true,
        background: '#ffffff',
        customClass: {
            popup: 'categoria-alert'
        }
    });

}


const mensajeSuccess = document.querySelector(
    '#categoria-success'
);

const mensajeError = document.querySelector(
    '#categoria-error'
);


mostrarNotificacion(
    mensajeSuccess,
    'success',
    '¡Operación exitosa!',
    3000
);


mostrarNotificacion(
    mensajeError,
    'error',
    'Error',
    3500
);


/*
|--------------------------------------------------------------------------
| Confirmación de eliminación / restauración
|--------------------------------------------------------------------------
*/

const formularios = document.querySelectorAll(
    '.categoria-modal form'
);

formularios.forEach(function (formulario) {

    formulario.addEventListener('submit', function () {

        const boton = formulario.querySelector(
            'button[type="submit"]'
        );

        if (!boton) {
            return;
        }

        boton.disabled = true;

        boton.innerHTML = `
            <span
                class="spinner-border spinner-border-sm me-1"
                role="status"
                aria-hidden="true">
            </span>
            Procesando...
        `;

    });

});


/*
|--------------------------------------------------------------------------
| Tooltips
|--------------------------------------------------------------------------
*/

const elementosTooltip = document.querySelectorAll(
    '[title]'
);

elementosTooltip.forEach(function (elemento) {

    if (typeof bootstrap !== 'undefined') {

        bootstrap.Tooltip.getOrCreateInstance(elemento);

    }

});

});
