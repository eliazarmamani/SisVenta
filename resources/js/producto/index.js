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

                placeholder: 'Buscar producto...',

                perPage: 'registros por página',

                noRows: 'No hay productos registrados',

                noResults: 'No se encontraron resultados',

                info: 'Mostrando {start} a {end} de {rows} productos'

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | CERRAR DROPDOWN AL ABRIR MODAL
    |--------------------------------------------------------------------------
    */

    const botonesModal = document.querySelectorAll(
        '[data-bs-toggle="modal"]'
    );

    botonesModal.forEach(function (boton) {

        boton.addEventListener('click', function () {

            const dropdown = boton.closest('.dropdown');

            if (dropdown) {

                const dropdownButton =
                    dropdown.querySelector('[data-bs-toggle="dropdown"]');

                if (
                    dropdownButton &&
                    typeof bootstrap !== 'undefined'
                ) {

                    const instancia =
                        bootstrap.Dropdown.getInstance(dropdownButton);

                    if (instancia) {
                        instancia.hide();
                    }

                }

            }

        });

    });

});