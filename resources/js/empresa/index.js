document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Confirmación antes de actualizar
    |--------------------------------------------------------------------------
    */

    const form = document.querySelector('.empresa-card form');

    if (!form) {
        return;
    }

    form.addEventListener('submit', function (event) {

        event.preventDefault();

        Swal.fire({
            title: '¿Actualizar información?',
            text: 'Los datos de la empresa serán modificados.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            confirmButtonColor: '#0d6efd'
        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }

        });

    });

});