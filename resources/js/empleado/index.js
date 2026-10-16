document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | DATATABLE
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
                placeholder: 'Buscar empleado...',
                perPage: 'registros por página',
                noRows: 'No se encontraron empleados',
                noResults: 'No se encontraron resultados',
                info: 'Mostrando {start} a {end} de {rows} empleados'
            }
        });

    }


    /*
    |--------------------------------------------------------------------------
    | MENSAJES DEL SISTEMA
    |--------------------------------------------------------------------------
    | El controller utiliza:
    | ->with('success', '...')
    | ->with('error', '...')
    |--------------------------------------------------------------------------
    */

    const systemAlert = document.querySelector('#empleado-alert');

    if (systemAlert && typeof Swal !== 'undefined') {

        const type = systemAlert.dataset.type;
        const message = systemAlert.dataset.message;

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


    /*
    |--------------------------------------------------------------------------
    | IMPORTAR EXCEL
    |--------------------------------------------------------------------------
    */

    const importForm = document.querySelector('#importEmpleadoForm');
    const fileInput = document.querySelector('#file');

    if (importForm && fileInput) {

        importForm.addEventListener('submit', (event) => {

            /*
            |--------------------------------------------------------------
            | Verificar archivo
            |--------------------------------------------------------------
            */

            if (!fileInput.files.length) {

                event.preventDefault();

                showAlert(
                    'warning',
                    'Archivo requerido',
                    'Selecciona un archivo Excel antes de continuar.'
                );

                return;
            }


            /*
            |--------------------------------------------------------------
            | Verificar extensión
            |--------------------------------------------------------------
            */

            const file = fileInput.files[0];

            const allowedExtensions = [
                'xlsx',
                'xls',
                'csv'
            ];

            const extension = file.name
                .split('.')
                .pop()
                .toLowerCase();

            if (!allowedExtensions.includes(extension)) {

                event.preventDefault();

                showAlert(
                    'error',
                    'Archivo no válido',
                    'Solo puedes importar archivos XLSX, XLS o CSV.'
                );

                fileInput.value = '';

                return;
            }


            /*
            |--------------------------------------------------------------
            | Mostrar estado de carga
            |--------------------------------------------------------------
            */

            const importButton = importForm.querySelector('.import-btn');

            if (importButton) {

                importButton.disabled = true;

                importButton.innerHTML = `
                    <i class="fas fa-spinner fa-spin"></i>
                    <span>Importando...</span>
                `;

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | ANIMACIÓN DE MODALES
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.empleado-modal').forEach((modal) => {

        modal.addEventListener('show.bs.modal', () => {

            const content = modal.querySelector('.modal-content');

            if (!content) {
                return;
            }

            content.style.transform = 'scale(.96)';
            content.style.opacity = '0';

            setTimeout(() => {

                content.style.transition =
                    'transform .18s ease, opacity .18s ease';

                content.style.transform = 'scale(1)';
                content.style.opacity = '1';

            }, 10);

        });


        /*
        |--------------------------------------------------------------
        | Limpiar estilos al cerrar
        |--------------------------------------------------------------
        */

        modal.addEventListener('hidden.bs.modal', () => {

            const content = modal.querySelector('.modal-content');

            if (!content) {
                return;
            }

            content.style.transform = '';
            content.style.opacity = '';
            content.style.transition = '';

        });

    });


    /*
    |--------------------------------------------------------------------------
    | FUNCIÓN PARA SWEETALERT
    |--------------------------------------------------------------------------
    */

    function showAlert(icon, title, text) {

        if (typeof Swal === 'undefined') {

            alert(`${title}\n\n${text}`);

            return;
        }

        const colors = {
            success: '#2563eb',
            warning: '#d97706',
            error: '#dc2626',
            info: '#2563eb'
        };

        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            confirmButtonText: 'Entendido',
            confirmButtonColor: colors[icon] || '#2563eb'
        });

    }

});