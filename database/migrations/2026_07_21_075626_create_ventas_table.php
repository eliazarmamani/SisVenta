<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            // Cliente registrado: opcional
            $table->foreignId('cliente_id')
                ->nullable()
                ->constrained('clientes')
                ->nullOnDelete();

            // Usuario que realiza la venta
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Comprobante seleccionado
            $table->foreignId('comprobante_id')
                ->constrained('comprobantes')
                ->cascadeOnDelete();

            $table->string('numero_comprobante')->unique();

            // Datos del comprador guardados en la venta
            $table->string('tipo_documento_cliente')->nullable();
            $table->string('numero_documento_cliente', 20)->nullable();
            $table->string('nombres_cliente')->nullable();
            $table->string('apellidos_cliente')->nullable();
            $table->string('razon_social_cliente')->nullable();
            $table->string('direccion_cliente')->nullable();

            // Datos del pago
            $table->enum('metodo_pago', ['EFECTIVO', 'TARJETA']);
            $table->dateTime('fecha_hora');

            // Totales
            $table->decimal('subtotal', 8, 2);
            $table->decimal('impuesto', 8, 2);
            $table->decimal('total', 8, 2);
            $table->decimal('monto_recibido', 8, 2);
            $table->decimal('vuelto_entregado', 8, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};