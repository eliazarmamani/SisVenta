<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empresa::insert([
            'nombre' => 'Eliaz SAC',
            'propietario' => 'Eliaz Code',
            'ruc' => '10768185315',
            'porcentaje_impuesto' => '18',
            'abreviatura_impuesto' => 'IGV',
            'direccion' => 'Av. Yanahuara 2paradero',
            'moneda_id' => 4
        ]);
    }
}
