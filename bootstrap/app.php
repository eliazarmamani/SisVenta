<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

use App\Http\Middleware\CheckProductoInicializado;
use App\Http\Middleware\CheckMovimientoCajaUserMiddleware;
use App\Http\Middleware\CheckCajaAperturadaUser;
use App\Http\Middleware\CheckShowVentaUser;
use App\Http\Middleware\CheckShowCompraUser;
use App\Http\Middleware\CheckUserEstado;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->redirectGuestsTo('/login');

        $middleware->alias([
            // Spatie Permission
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,

            // Middleware del sistema
            'check_producto_inicializado' => CheckProductoInicializado::class,
            'check_movimiento_caja_user' => CheckMovimientoCajaUserMiddleware::class,
            'check-caja-aperturada-user' => CheckCajaAperturadaUser::class,
            'check-show-venta-user' => CheckShowVentaUser::class,
            'check-show-compra-user' => CheckShowCompraUser::class,
            'check-user-estado' => CheckUserEstado::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // Error 404: página no encontrada.
        $exceptions->render(function (
            NotFoundHttpException $e,
            Request $request
        ) {
            if ($request->expectsJson()) {
                return null;
            }

            return response()->view('errors.404', [], 404);
        });

        // Errores HTTP 401 y 403.
        $exceptions->render(function (
            HttpException $e,
            Request $request
        ) {
            if ($request->expectsJson()) {
                return null;
            }

            $status = $e->getStatusCode();

            if ($status === 401) {
                return response()->view('errors.401', [], 401);
            }

            if ($status === 403) {
                return response()->view('errors.403', [], 403);
            }

            return null;
        });

        // Error 500: página personalizada solo en producción.
        $exceptions->render(function (
            \Throwable $e,
            Request $request
        ) {
            if (
                ! app()->environment('production') ||
                $request->expectsJson()
            ) {
                return null;
            }

            return response()->view('errors.500', [], 500);
        });

    })
    ->create();