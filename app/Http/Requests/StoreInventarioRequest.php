<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventarioRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación para la creación del inventario.
     */
    public function rules(): array
    {
        return [
            'producto_id' => 'required|exists:productos,id',
            'ubicacione_id' => 'required|exists:ubicaciones,id',
        ];
    }
}