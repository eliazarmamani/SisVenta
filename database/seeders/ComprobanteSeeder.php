<?php

namespace Database\Seeders;

use App\Models\Comprobante;
use Illuminate\Database\Seeder;

class ComprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comprobantes = [
            'Boleta',
            'Factura',
            'nota de venta',
        ];

        foreach ($comprobantes as $comprobante) {
            Comprobante::firstOrCreate([
                'nombre' => $comprobante,
            ]);
        }
    }
}