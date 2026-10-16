document.addEventListener('DOMContentLoaded', () => {

    const form = document.querySelector('.empleado-edit-page form');
    const btnUpdate = document.getElementById('btnUpdate');
    const btnCancel = document.getElementById('btnCancel');

    /*
    |--------------------------------------------------------------------------
    | FOCUS AUTOMÁTICO
    |--------------------------------------------------------------------------
    */

    const firstInput = document.querySelector(
        '.empleado-edit-page input:not([type="hidden"])'
    );

    if (firstInput) {
        firstInput.focus();
    }


    /*
    |--------------------------------------------------------------------------
    | CAPITALIZAR NOMBRES
    |--------------------------------------------------------------------------
    */

    const razonSocial = document.getElementById('razon_social');

    if (razonSocial) {

        razonSocial.addEventListener('blur', () => {

            razonSocial.value = razonSocial.value
                .trim()
                .replace(/\s+/g, ' ')
                .replace(/\b\w/g, letra => letra.toUpperCase());

        });

    }


    /*
    |--------------------------------------------------------------------------
    | LIMPIAR ESPACIOS DEL CARGO
    |--------------------------------------------------------------------------
    */

    const cargo = document.getElementById('cargo');

    if (cargo) {

        cargo.addEventListener('blur', () => {

            cargo.value = cargo.value
                .trim()
                .replace(/\s+/g, ' ');

        });

    }


    /*
    |--------------------------------------------------------------------------
    | ENVÍO DEL FORMULARIO
    |--------------------------------------------------------------------------
    */

    if (form && btnUpdate) {

        form.addEventListener('submit', () => {

            btnUpdate.classList.add('loading');

            btnUpdate.disabled = true;

            const icon = btnUpdate.querySelector('i');
            const text = btnUpdate.querySelector('span');

            if (icon) {
                icon.className = 'fas fa-spinner';
            }

            if (text) {
                text.textContent = 'Guardando...';
            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | CONFIRMACIÓN AL CANCELAR
    |--------------------------------------------------------------------------
    */

    if (btnCancel) {

        btnCancel.addEventListener('click', (event) => {

            const hasChanges =
                form &&
                [...form.querySelectorAll('input, select, textarea')]
                    .some(input => input.value !== input.defaultValue);

            if (hasChanges) {

                const confirmar = confirm(
                    'Tienes cambios sin guardar. ¿Deseas salir sin guardar?'
                );

                if (!confirmar) {
                    event.preventDefault();
                }

            }

        });

    }

});