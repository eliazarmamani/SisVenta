<?php

namespace App\Http\Requests;

use App\Enums\MetodoPagoEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreCompraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            // Datos generales de la compra
            'proveedore_id' => 'required|exists:proveedores,id',

            'comprobante_id' => 'required|exists:comprobantes,id',

            'numero_comprobante' => 'nullable|max:255',

            'file_comprobante' => 'nullable|file|mimes:pdf|max:2048',

            'metodo_pago' => [
                'required',
                new Enum(MetodoPagoEnum::class),
            ],

            'fecha_hora' => [
                'required',
                'date',
                'date_format:Y-m-d\TH:i',
            ],

            // Detalle de productos
            'arrayidproducto' => 'required|array|min:1',
            'arrayidproducto.*' => 'required|exists:productos,id',

            'arraycantidad' => 'required|array|min:1',
            'arraycantidad.*' => 'required|integer|min:1',

            // Precio de compra unitario INCLUIDO IGV
            'arraypreciocompra' => 'required|array|min:1',
            'arraypreciocompra.*' => 'required|numeric|min:0.01',

            // Precio de venta unitario
            'arrayprecioventa' => 'required|array|min:1',
            'arrayprecioventa.*' => 'required|numeric|min:0.01',

            // Fecha de vencimiento
            'arrayfechavencimiento' => 'nullable|array',
            'arrayfechavencimiento.*' => 'nullable|date',

            // Totales enviados por el formulario
            'subtotal' => 'required|numeric|min:0',

            'impuesto' => 'required|numeric|min:0',

            'total' => 'required|numeric|min:0.01',
        ];
    }
}