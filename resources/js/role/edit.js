/* =========================================================
SISVENTA - EDITAR ROL
JavaScript del formulario
========================================================= */

document.addEventListener('DOMContentLoaded', () => {

const form = document.getElementById('roleEditForm');

const nameInput = document.getElementById('name');
const nameCounter = document.getElementById('nameCounter');

const searchInput = document.getElementById('permissionSearch');

const selectAllButton = document.getElementById('selectAll');
const clearAllButton = document.getElementById('clearAll');

const permissionCounter =
    document.getElementById('permissionCounter');

const permissionCounterSmall =
    document.getElementById('permissionCounterSmall');

const permissionProgress =
    document.getElementById('permissionProgress');

const permissionStatus =
    document.getElementById('permissionStatus');

const resetButton =
    document.getElementById('resetForm');

const submitButton =
    document.getElementById('submitButton');


const permissionItems = Array.from(
    document.querySelectorAll('.permission-item')
);

const permissionCheckboxes = Array.from(
    document.querySelectorAll('.permission-checkbox')
);


/* =====================================================
   CONTADOR DEL NOMBRE
====================================================== */

const updateNameCounter = () => {

    if (!nameInput || !nameCounter) {
        return;
    }

    nameCounter.textContent =
        nameInput.value.length;

};


if (nameInput) {

    nameInput.addEventListener('input', () => {

        nameInput.value = nameInput.value
            .replace(/\s{2,}/g, ' ');

        updateNameCounter();

    });

    updateNameCounter();

}


/* =====================================================
   PERMISOS SELECCIONADOS
====================================================== */

const updatePermissions = () => {

    const total = permissionCheckboxes.length;

    const selected = permissionCheckboxes.filter(
        checkbox => checkbox.checked
    ).length;


    /* Contadores */
    if (permissionCounter) {
        permissionCounter.textContent = selected;
    }

    if (permissionCounterSmall) {
        permissionCounterSmall.textContent = selected;
    }


    /* Porcentaje */
    const percentage = total > 0
        ? (selected / total) * 100
        : 0;


    if (permissionProgress) {
        permissionProgress.style.width =
            `${percentage}%`;
    }


    /* Estado */
    if (permissionStatus) {

        if (selected === 0) {

            permissionStatus.textContent =
                'Selecciona los permisos necesarios.';

        } else if (selected === total) {

            permissionStatus.textContent =
                'Todos los permisos están seleccionados.';

        } else {

            permissionStatus.textContent =
                `${selected} permiso${selected === 1 ? '' : 's'} seleccionado${selected === 1 ? '' : 's'}.`;

        }

    }


    /* Estado visual */
    permissionItems.forEach(item => {

        const checkbox =
            item.querySelector('.permission-checkbox');

        if (!checkbox) {
            return;
        }

        item.classList.toggle(
            'selected',
            checkbox.checked
        );

    });

};


permissionCheckboxes.forEach(checkbox => {

    checkbox.addEventListener(
        'change',
        updatePermissions
    );

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

            const checkbox =
                item.querySelector('.permission-checkbox');

            if (checkbox) {
                checkbox.checked = true;
            }

        });

        updatePermissions();

    });

}


/* =====================================================
   LIMPIAR PERMISOS
====================================================== */

if (clearAllButton) {

    clearAllButton.addEventListener('click', () => {

        permissionCheckboxes.forEach(
            checkbox => {
                checkbox.checked = false;
            }
        );

        updatePermissions();

    });

}


/* =====================================================
   BUSCAR PERMISOS
====================================================== */

if (searchInput) {

    searchInput.addEventListener('input', () => {

        const search = searchInput.value
            .trim()
            .toLowerCase();


        permissionItems.forEach(item => {

            const permission =
                (item.dataset.permission || '')
                .toLowerCase();

            const matches =
                permission.includes(search);

            item.style.display =
                matches ? 'flex' : 'none';

        });

    });

}


/* =====================================================
   REINICIAR FORMULARIO
====================================================== */

if (resetButton) {

    resetButton.addEventListener('click', () => {

        /*
         * Esperamos al reset nativo del navegador
         * para actualizar los estados visuales.
         */
        setTimeout(() => {

            updateNameCounter();
            updatePermissions();

        }, 0);

    });

}


/* =====================================================
   ENVÍO DEL FORMULARIO
====================================================== */

if (form && submitButton) {

    form.addEventListener('submit', () => {

        submitButton.disabled = true;

        submitButton.innerHTML = `
            <i class="fa-solid fa-spinner fa-spin"></i>
            <span>Actualizando...</span>
        `;

    });

}


/* =====================================================
   INICIALIZACIÓN
====================================================== */

updateNameCounter();
updatePermissions();

});
