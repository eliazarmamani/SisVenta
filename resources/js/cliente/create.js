document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | ELEMENTOS
    |--------------------------------------------------------------------------
    */

    const tipo = document.querySelector('#tipo');
    const boxRazonSocial = document.querySelector('#box-razon-social');
    const labelNatural = document.querySelector('#label-natural');
    const labelJuridica = document.querySelector('#label-juridica');
    const razonSocial = document.querySelector('#razon_social');


    /*
    |--------------------------------------------------------------------------
    | CAMBIAR TIPO DE CLIENTE
    |--------------------------------------------------------------------------
    */

    function actualizarTipoCliente() {

        if (!tipo || !boxRazonSocial) {
            return;
        }

        const valor = tipo.value;

        if (!valor) {
            boxRazonSocial.classList.remove('visible');
            return;
        }

        boxRazonSocial.classList.add('visible');

        if (valor === 'NATURAL') {

            labelNatural.classList.remove('d-none');
            labelJuridica.classList.add('d-none');

            razonSocial.placeholder =
                'Ingrese nombres y apellidos';

        } else {

            labelNatural.classList.add('d-none');
            labelJuridica.classList.remove('d-none');

            razonSocial.placeholder =
                'Ingrese el nombre de la empresa';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | EVENTO
    |--------------------------------------------------------------------------
    */

    if (tipo) {

        tipo.addEventListener(
            'change',
            actualizarTipoCliente
        );

    }


    /*
    |--------------------------------------------------------------------------
    | RECUPERAR VALOR DESPUÉS DE VALIDACIÓN
    |--------------------------------------------------------------------------
    */

    actualizarTipoCliente();


    /*
    |--------------------------------------------------------------------------
    | BOTÓN GUARDAR
    |--------------------------------------------------------------------------
    */

    const formulario = document.querySelector(
        '.cliente-form-card form'
    );

    if (formulario) {

        formulario.addEventListener(
            'submit',
            function () {

                const boton = formulario.querySelector(
                    'button[type="submit"]'
                );

                if (!boton) {
                    return;
                }

                boton.disabled = true;

                boton.innerHTML = `
                    <span
                        class="spinner-border spinner-border-sm"
                        role="status"
                        aria-hidden="true">
                    </span>
                    Guardando...
                `;

            }
        );

    }

});