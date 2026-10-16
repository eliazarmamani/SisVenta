document.addEventListener('DOMContentLoaded', () => {

    const form = document.querySelector('form');
    const btnGuardar = document.querySelector('#btnGuardar');

    if (!form || !btnGuardar) {
        return;
    }

    form.addEventListener('submit', () => {

        if (form.checkValidity()) {

            btnGuardar.disabled = true;

            btnGuardar.innerHTML = `
                <i class="fas fa-spinner fa-spin"></i>
                <span>Guardando...</span>
            `;
        }
    });

    /*
    |--------------------------------------------------------------------------
    | MAYÚSCULAS EN NOMBRES Y APELLIDOS
    |--------------------------------------------------------------------------
    */

    const nombreInput = document.querySelector('#razon_social');

    if (nombreInput) {

        nombreInput.addEventListener('input', () => {

            nombreInput.value = nombreInput.value
                .replace(/\s+/g, ' ')
                .replace(/^\s+/, '');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | LIMPIAR ESPACIOS DEL CARGO
    |--------------------------------------------------------------------------
    */

    const cargoInput = document.querySelector('#cargo');

    if (cargoInput) {

        cargoInput.addEventListener('input', () => {

            cargoInput.value = cargoInput.value
                .replace(/\s+/g, ' ')
                .replace(/^\s+/, '');
        });
    }

});