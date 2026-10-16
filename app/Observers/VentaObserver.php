<?php

namespace App\Observers;

use App\Models\Caja;
use App\Models\Comprobante;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VentaObserver
{
    /**
     * Handle the Venta "creating" event.
     */
    public function creating(Venta $venta): void
    {
        // Buscar la caja aperturada del usuario actual
        $caja = Caja::where('user_id', Auth::id())
            ->where('estado', 1)
            ->firstOrFail();

        // Obtener el comprobante seleccionado
        $comprobante = Comprobante::findOrFail(
            $venta->comprobante_id
        );

        // Asignar usuario y caja
        $venta->user_id = Auth::id();
        $venta->caja_id = $caja->id;

        // Generar número de comprobante
        $venta->numero_comprobante = $venta->generarNumeroVenta(
            $caja->id,
            $comprobante->nombre
        );

        // Registrar fecha y hora
        $venta->fecha_hora = Carbon::now()->toDateTimeString();
    }

    /**
     * Handle the Venta "created" event.
     */
    public function created(Venta $venta): void
    {
        //
    }

    /**
     * Handle the Venta "updated" event.
     */
    public function updated(Venta $venta): void
    {
        //
    }

    /**
     * Handle the Venta "deleted" event.
     */
    public function deleted(Venta $venta): void
    {
        //
    }

    /**
     * Handle the Venta "restored" event.
     */
    public function restored(Venta $venta): void
    {
        //
    }

    /**
     * Handle the Venta "force deleted" event.
     */
    public function forceDeleted(Venta $venta): void
    {
        //
    }
}