# SisVenta

Sistema de ventas desarrollado con Laravel para la gestión de productos, compras, ventas y operaciones de caja.

## Descripción

SisVenta es un proyecto web orientado a facilitar la administración de las operaciones comerciales de una tienda desde una plataforma centralizada.

## Tecnologías utilizadas

- **Backend:** PHP y Laravel.
- **Base de datos:** MySQL.
- **Frontend:** HTML, CSS, JavaScript y Bootstrap.
- **Herramientas:** Composer, Node.js, NPM y Vite.
- **Control de versiones:** Git y GitHub.
- **Pruebas:** PHPUnit y GitHub Actions.

## Requisitos previos

Antes de instalar el proyecto, necesitas:

- PHP compatible con la versión de Laravel del proyecto.
- Composer.
- MySQL.
- Node.js y NPM.
- Git.

## Instalación

1. Descarga o clona el repositorio.
2. Instala las dependencias de PHP:

   ```bash
   composer install
   ```

3. Crea el archivo de configuración:

   ```bash
   cp .env.example .env
   ```

   En Windows, también puedes copiar manualmente `.env.example` y nombrar la copia `.env`.

4. Genera la clave de la aplicación:

   ```bash
   php artisan key:generate
   ```

5. Crea una base de datos MySQL y configura las variables `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD` en el archivo `.env`.

6. Ejecuta las migraciones según la configuración de la base de datos:

   ```bash
   php artisan migrate
   ```

7. Instala las dependencias del frontend:

   ```bash
   npm install
   ```

8. Compila los recursos del frontend:

   ```bash
   npm run build
   ```

9. Inicia el servidor de desarrollo:

   ```bash
   php artisan serve
   ```

10. Abre la dirección que indique Laravel en tu navegador.

## Pruebas

El proyecto utiliza PHPUnit para ejecutar pruebas automatizadas. También cuenta con una configuración de GitHub Actions para ejecutar pruebas al realizar cambios en la rama principal.

Para ejecutar las pruebas localmente:

```bash
php artisan test
```

## Estado del proyecto

Proyecto en desarrollo. Las funcionalidades y configuraciones pueden cambiar conforme avance su implementación.

## Autor

**Eliazar Mamani Huillhua**

Repositorio: [SisVenta en GitHub](https://github.com/eliazarmamani/SisVenta)

