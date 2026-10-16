<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('compra_producto', function (Blueprint $table) {

            $table->id();

            // Compra a la que pertenece el detalle
            $table->foreignId('compra_id')
                ->constrained('compras')
                ->cascadeOnDelete();

            // Producto comprado
            $table->foreignId('producto_id')
                ->constrained('productos')
                ->cascadeOnDelete();

            // Cantidad comprada
            $table->unsignedInteger('cantidad');

            // Precio unitario de compra, incluido IGV
            $table->decimal('precio_compra', 10, 2);

            // Precio unitario de venta
            $table->decimal('precio_venta', 10, 2);

            // Fecha de vencimiento del producto
            $table->date('fecha_vencimiento')
                ->nullable();

            $table->timestamps();

            // Evita registrar dos veces el mismo producto
            // dentro de una misma compra.
            $table->unique(['compra_id', 'producto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compra_producto');
    }
};