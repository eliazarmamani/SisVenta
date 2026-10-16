<?php

namespace App\Observers;

use App\Models\Inventario;
use App\Models\Producto;

class InventarioObserver
{
    /**
     * Se ejecuta cuando se crea un registro de inventario.
     *
     * Al crear el inventario, el producto queda marcado
     * como inicializado.
     */
    public function created(Inventario $inventario): void
    {
        Producto::where('id', $inventario->producto_id)
            ->update([
                'estado' => 1,
            ]);
    }

    /**
     * Se ejecuta cuando se actualiza el inventario.
     */
    public function updated(Inventario $inventario): void
    {
        //
    }

    /**
     * Se ejecuta cuando se guarda el inventario.
     */
    public function saved(Inventario $inventario): void
    {
        //
    }

    /**
     * Se ejecuta cuando se elimina el inventario.
     */
    public function deleted(Inventario $inventario): void
    {
        //
    }

    /**
     * Se ejecuta cuando se restaura el inventario.
     */
    public function restored(Inventario $inventario): void
    {
        //
    }

    /**
     * Se ejecuta cuando se elimina definitivamente el inventario.
     */
    public function forceDeleted(Inventario $inventario): void
    {
        //
    }
}