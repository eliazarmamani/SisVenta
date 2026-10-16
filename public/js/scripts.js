/*!
 * Este código sirve para abrir y cerrar el menú lateral (sidebar)
 */

 // Espera a que toda la página termine de cargar
window.addEventListener('DOMContentLoaded', event => {

    // Busca el botón que tiene el id "sidebarToggle"
    // (ese botón es el de las 3 rayitas del menú)
    const sidebarToggle = document.body.querySelector('#sidebarToggle');

    // Si el botón existe...
    if (sidebarToggle) {

        // 🔹 Si quisieras que el menú recuerde si estaba abierto o cerrado
        //    aunque recargues la página, puedes activar este bloque:
        // 

        // Cuando se hace clic en el botón
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault(); // evita que el botón haga otra acción

            // 🔹 Cambia la clase del body para mostrar u ocultar el menú
            // Si el menú está visible → lo esconde
            // Si está escondido → lo muestra
            document.body.classList.toggle('sb-sidenav-toggled');

            // 🔹 Guarda en la memoria del navegador (localStorage)
            // si el menú está abierto o cerrado, para recordarlo
            localStorage.setItem(
                'sb|sidebar-toggle',
                document.body.classList.contains('sb-sidenav-toggled')
            );
        });
    }

});
