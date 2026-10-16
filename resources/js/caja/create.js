document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Formulario de apertura de caja
    |--------------------------------------------------------------------------
    */

    const formulario = document.querySelector(
        '.caja-create-card form'
    );

    if (!formulario) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Botón de apertura
    |--------------------------------------------------------------------------
    */

    const boton = formulario.querySelector(
        '.btn-caja-aperturar'
    );

    if (!boton) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Evitar doble envío
    |--------------------------------------------------------------------------
    */

    formulario.addEventListener('submit', function (event) {

        // Si el botón ya está deshabilitado,
        // evitamos un segundo envío.
        if (boton.disabled) {
            event.preventDefault();
            return;
        }

        // Deshabilitar el botón.
        boton.disabled = true;

        // Mostrar estado de procesamiento.
        boton.innerHTML = `
            <span
                class="spinner-border spinner-border-sm"
                role="status"
                aria-hidden="true">
            </span>

            Aperturando...
        `;
    });


    /*
    |--------------------------------------------------------------------------
    | Validación visual del saldo inicial
    |--------------------------------------------------------------------------
    */

    const saldoInicial = document.getElementById(
        'saldo_inicial'
    );

    if (!saldoInicial) {
        return;
    }

    saldoInicial.addEventListener('input', function () {

        if (this.value < 0) {
            this.value = 0;
        }

    });

});