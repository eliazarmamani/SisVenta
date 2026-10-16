import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS
                'resources/css/caja/index.css',
                'resources/css/caja/create.css',
                'resources/css/role/index.css',
                'resources/css/role/create.css',
                'resources/css/role/edit.css',
                'resources/css/user/index.css',
                'resources/css/user/create.css',
                'resources/css/user/edit.css',
                'resources/css/empresa/index.css',
                'resources/css/empleado/index.css',
                'resources/css/empleado/create.css',
                'resources/css/empleado/edit.css',
                'resources/css/categoria/index.css',
                'resources/css/categoria/create.css',
                'resources/css/categoria/edit.css',
                'resources/css/presentacione/index.css',
                'resources/css/marca/index.css',
                'resources/css/producto/index.css',
                'resources/css/cliente/index.css',
                'resources/css/cliente/create.css',

                // JavaScript
                'resources/js/caja/index.js',
                'resources/js/caja/create.js',
                'resources/js/role/index.js',
                'resources/js/role/create.js',
                'resources/js/role/edit.js',
                'resources/js/user/index.js',
                'resources/js/user/create.js',
                'resources/js/user/edit.js',
                'resources/js/empresa/index.js',
                'resources/js/empleado/index.js',
                'resources/js/empleado/create.js',
                'resources/js/empleado/edit.js',
                'resources/js/categoria/index.js',
                'resources/js/categoria/create.js',
                'resources/js/categoria/edit.js',
                'resources/js/presentacione/index.js',
                'resources/js/marca/index.js',
                'resources/js/producto/index.js',
                'resources/js/cliente/index.js',
                'resources/js/cliente/create.js',
                'resources/js/venta/create.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});