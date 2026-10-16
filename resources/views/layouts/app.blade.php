<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- =========================================================
         CONFIGURACIÓN BÁSICA DEL DOCUMENTO
         ========================================================= --}}

    {{-- Permite utilizar caracteres especiales correctamente --}}
    <meta charset="utf-8" />

    {{-- Compatibilidad con Internet Explorer --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    {{-- Hace que la página sea adaptable a celulares, tablets y PC --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    {{-- Descripción de nuestro sistema --}}
    <meta name="description" content="Sistema de ventas de abarrotes" />

    {{-- Autor del proyecto --}}
    <meta name="author" content="Eliazar" />

    {{-- Token de seguridad utilizado por Laravel para formularios y peticiones --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">


    {{-- =========================================================
         TÍTULO DE LA PÁGINA
         ========================================================= --}}

    {{-- 
        @yield('title') permite que cada vista coloque su propio título.

        Ejemplo:
        @section('title', 'Productos')

        Resultado:
        Sistema ventas - Productos
    --}}
    <title>Sistema ventas - @yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/icon.png') }}">


    {{-- =========================================================
         CSS DE DATATABLE
         ========================================================= --}}

    {{-- 
        Permite que cada vista agregue sus propios estilos
        relacionados con DataTables.

        Ejemplo en una vista:
        @push('css-datatable')
            <link ...>
        @endpush
    --}}
    @stack('css-datatable')


    {{-- =========================================================
         BOOTSTRAP
         ========================================================= --}}

    {{-- 
        Bootstrap está actualmente comentado.
        Por eso esta línea NO se ejecuta.

        Si algún día quieres utilizar el CDN de Bootstrap,
        puedes habilitarlo.
    --}}
    <!--
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9"
        crossorigin="anonymous"
    >
    -->


    {{-- =========================================================
         CSS PRINCIPAL DEL SISTEMA
         ========================================================= --}}

    {{-- 
        Carga el archivo CSS general de Laravel/SisVenta.

        Ubicación:
        public/css/styles.css
    --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />


    {{-- =========================================================
         FONT AWESOME
         ========================================================= --}}

    {{-- 
        Carga Font Awesome para utilizar iconos.

        Ejemplo:
        <i class="fas fa-home"></i>
    --}}
    <script
        src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"
        crossorigin="anonymous">
    </script>


    {{-- =========================================================
         CSS PERSONALIZADO DE CADA VISTA
         ========================================================= --}}

    {{-- 
        @stack('css') permite que cada módulo agregue
        su propio archivo CSS.

        Ejemplo:
        @push('css')
            @vite('resources/css/role/index.css')
        @endpush
    --}}
    @stack('css')

</head>


<body class="sb-nav-fixed">


    {{-- =========================================================
         NAVBAR / ENCABEZADO SUPERIOR
         ========================================================= --}}

    {{-- 
        Aquí se carga el archivo que contiene
        el menú superior de nuestro sistema.

        Archivo:
        resources/views/layouts/include/navigation-header.blade.php

        AQUÍ PROBABLEMENTE COLOCAREMOS EL LOGO
        DEL SISTEMA EN EL NAVBAR.
    --}}
    @include('layouts.include.navigation-header')


    {{-- =========================================================
         ESTRUCTURA PRINCIPAL DEL SISTEMA
         ========================================================= --}}

    <div id="layoutSidenav">


        {{-- =====================================================
             MENÚ LATERAL / SIDEBAR
             ===================================================== --}}

        {{-- 
            Aquí se carga el menú lateral.

            Archivo:
            resources/views/layouts/include/navigation-menu.blade.php

            También podemos colocar el logo aquí si quieres
            que aparezca en la parte superior del sidebar.
        --}}
        @include('layouts.include.navigation-menu')


        {{-- =====================================================
             CONTENIDO PRINCIPAL
             ===================================================== --}}

        <div id="layoutSidenav_content">


            {{-- =================================================
                 MENSAJES / ALERTAS
                 ================================================= --}}

            {{-- 
                Aquí aparecen mensajes como:

                - Guardado correctamente
                - Eliminado correctamente
                - Error
                - Advertencias
            --}}
            @include('layouts.partials.alert')


            {{-- =================================================
                 CONTENIDO DE CADA VISTA
                 ================================================= --}}

            <main>

                {{-- 
                    @yield('content') es MUY IMPORTANTE.

                    Aquí Laravel coloca el contenido de cada vista.

                    Por ejemplo, una vista puede tener:

                    @section('content')
                        <h1>Productos</h1>
                    @endsection

                    Ese contenido aparecerá exactamente aquí.
                --}}
                @yield('content')

            </main>


            {{-- =================================================
                 PIE DE PÁGINA
                 ================================================= --}}

            {{-- 
                Carga el footer del sistema.

                Archivo:
                resources/views/layouts/include/footer.blade.php
            --}}
            @include('layouts.include.footer')


        </div>

    </div>


    {{-- =========================================================
         JAVASCRIPT DE BOOTSTRAP
         ========================================================= --}}

    {{-- 
        Carga Bootstrap JavaScript.

        Se utiliza para componentes como:
        - Modales
        - Dropdowns
        - Menús
        - Alertas
        - Offcanvas
    --}}
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous">
    </script>


    {{-- =========================================================
         JAVASCRIPT PRINCIPAL DEL SISTEMA
         ========================================================= --}}

    {{-- 
        Carga el JavaScript general.

        Ubicación:
        public/js/scripts.js
    --}}
    <script src="{{ asset('js/scripts.js') }}"></script>


    {{-- =========================================================
         SISTEMA DE NOTIFICACIONES
         ========================================================= --}}

    <script>

        // Esperamos hasta que todo el HTML haya cargado
        document.addEventListener('DOMContentLoaded', function () {

            // Buscamos el botón/icono de notificaciones
            const notificationIcon =
                document.getElementById('notificationsDropdown');


            // Cuando el usuario hace clic en las notificaciones
            notificationIcon.addEventListener('click', function () {

                // Enviamos una petición a Laravel
                fetch("{{ route('notifications.markAsRead') }}", {

                    // Tipo de petición
                    method: "POST",

                    // Datos de seguridad
                    headers: {

                        // Token CSRF de Laravel
                        "X-CSRF-TOKEN":
                            document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),

                        // Indicamos que enviamos JSON
                        "Content-Type": "application/json"
                    },

                    // En este caso no necesitamos enviar datos
                    body: JSON.stringify({})

                })

                // Convertimos la respuesta a JSON
                .then(response => response.json())

                // Revisamos la respuesta
                .then(data => {

                    // Si Laravel indica que fue exitoso
                    if (data.success) {

                        // Buscamos el número rojo de notificaciones
                        const badge =
                            notificationIcon.querySelector('.badge');

                        // Si existe, lo eliminamos
                        if (badge) {
                            badge.remove();
                        }
                    }

                })

                // Si ocurre algún error
                .catch(error =>
                    console.error(
                        'Error al marcar notificaciones como leídas:',
                        error
                    )
                );

            });

        });

    </script>


    {{-- =========================================================
         JAVASCRIPT PERSONALIZADO DE CADA VISTA
         ========================================================= --}}

    {{-- 
        Igual que @stack('css'), esto permite que cada módulo
        agregue su propio JavaScript.

        Ejemplo:

        @push('js')
            <script>
                // JavaScript del módulo
            </script>
        @endpush
    --}}
    @stack('js')


</body>

</html>