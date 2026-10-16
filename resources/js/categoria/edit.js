document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Elementos del formulario
    |--------------------------------------------------------------------------
    */

    const formulario = document.querySelector('form');
    const btnReset = document.getElementById('btnReset');
    const nombre = document.getElementById('nombre');


    /*
    |--------------------------------------------------------------------------
    | Reiniciar formulario
    |--------------------------------------------------------------------------
    */

    if (btnReset && formulario) {

        btnReset.addEventListener('click', function () {

            setTimeout(function () {

                if (nombre) {
                    nombre.focus();
                }

            }, 100);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Notificaciones
    |--------------------------------------------------------------------------
    */

    const notificacion = document.getElementById('notificacion');

    if (notificacion && typeof Swal !== 'undefined') {

        const tipo = notificacion.dataset.tipo;
        const mensaje = notificacion.dataset.mensaje;

        if (tipo && mensaje) {

            Swal.fire({
                icon: tipo,
                title: tipo === 'success'
                    ? '¡Operación exitosa!'
                    : 'Ocurrió un problema',
                text: mensaje,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#0d6efd',
                timer: tipo === 'success' ? 3000 : undefined,
                timerProgressBar: tipo === 'success'
            });

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Errores de validación
    |--------------------------------------------------------------------------
    */

    const errores = document.getElementById('errores-validacion');

    if (errores && typeof Swal !== 'undefined') {

        const listaErrores = JSON.parse(errores.dataset.errores);

        if (listaErrores.length > 0) {

            Swal.fire({
                icon: 'warning',
                title: 'Revisa los datos',
                html: `
                    <div class="text-start">
                        <ul class="mb-0">
                            ${listaErrores.map(error => `<li>${error}</li>`).join('')}
                        </ul>
                    </div>
                `,
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#f0ad4e'
            });

        }

    }

});