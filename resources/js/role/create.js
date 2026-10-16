/* =========================================================
   SISVENTA - CREAR ROL
   JavaScript del formulario
   ========================================================= */

document.addEventListener('DOMContentLoaded', () => {

    /* =====================================================
       ELEMENTOS
    ====================================================== */

    const form = document.getElementById('roleCreateForm');
    const nameInput = document.getElementById('name');

    const searchInput = document.getElementById('permissionSearch');

    const selectAllButton = document.getElementById('selectAll');
    const clearAllButton = document.getElementById('clearAll');

    const selectedCount = document.getElementById('selectedCount');

    const saveButton = document.getElementById('saveRole');

    const permissionItems = Array.from(
        document.querySelectorAll('.permission-item')
    );

    const permissionCheckboxes = Array.from(
        document.querySelectorAll('.permission-checkbox')
    );


    /* =====================================================
       ACTUALIZAR CONTADOR
    ====================================================== */

    const updateSelectedCount = () => {

        const selected = permissionCheckboxes.filter(
            checkbox => checkbox.checked
        ).length;

        if (selectedCount) {
            selectedCount.textContent = selected;
        }

        permissionItems.forEach(item => {

            const checkbox = item.querySelector(
                '.permission-checkbox'
            );

            if (checkbox) {
                item.classList.toggle(
                    'selected',
                    checkbox.checked
                );
            }

        });

    };


    /* =====================================================
       CAMBIAR ESTADO DEL PERMISO
    ====================================================== */

    permissionCheckboxes.forEach(checkbox => {

        checkbox.addEventListener('change', () => {
            updateSelectedCount();
        });

    });


    /* =====================================================
       SELECCIONAR TODOS
    ====================================================== */

    if (selectAllButton) {

        selectAllButton.addEventListener('click', () => {

            permissionItems.forEach(item => {

                if (item.style.display === 'none') {
                    return;
                }

                const checkbox = item.querySelector(
                    '.permission-checkbox'
                );

                if (checkbox) {
                    checkbox.checked = true;
                }

            });

            updateSelectedCount();

        });

    }


    /* =====================================================
       LIMPIAR TODOS
    ====================================================== */

    if (clearAllButton) {

        clearAllButton.addEventListener('click', () => {

            permissionCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });

            updateSelectedCount();

        });

    }


    /* =====================================================
       BUSCADOR DE PERMISOS
    ====================================================== */

    if (searchInput) {

        searchInput.addEventListener('input', () => {

            const search = searchInput.value
                .trim()
                .toLowerCase();

            permissionItems.forEach(item => {

                const permission = (
                    item.dataset.permission || ''
                ).toLowerCase();

                const matches = permission.includes(search);

                item.style.display = matches
                    ? 'flex'
                    : 'none';

            });

        });

    }


    /* =====================================================
       NOMBRE DEL ROL
    ====================================================== */

    if (nameInput) {

        nameInput.addEventListener('input', () => {

            nameInput.value = nameInput.value
                .replace(/\s{2,}/g, ' ');

        });

    }


    /* =====================================================
       ENVÍO DEL FORMULARIO
    ====================================================== */

    if (form && saveButton) {

        form.addEventListener('submit', () => {

            saveButton.disabled = true;

            saveButton.innerHTML = `
                <i class="fa-solid fa-spinner fa-spin"></i>
                <span>Guardando...</span>
            `;

        });

    }


    /* =====================================================
       INICIALIZAR
    ====================================================== */

    updateSelectedCount();

});