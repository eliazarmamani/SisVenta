<?php

namespace App\Events;

use App\Models\Compra;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateCompraDetalleEvent
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * Este evento se ejecuta cuando se registra un detalle de compra.
     * Transporta la información necesaria para que los listeners
     * actualicen el inventario, registren el movimiento en el Kardex
     * y procesen los datos relacionados con la compra.
     */
    public function __construct(
        public Compra $compra,
        public $producto_id,
        public $cantidad,
        public $precio_compra,
        public $precio_venta,
        public $fecha_vencimiento
    ) {}

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [];
    }
}