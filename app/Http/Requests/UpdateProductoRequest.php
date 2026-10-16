<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $producto = $this->route('producto');

        return [
            'codigo' => 'nullable|unique:productos,codigo,' . $producto->id . '|max:50',

            'nombre' => 'required|unique:productos,nombre,' . $producto->id . '|max:255',

            'descripcion' => 'nullable|max:255',

            'marca_id' => 'nullable|integer|exists:marcas,id',

            'presentacione_id' => 'required|integer|exists:presentaciones,id',

            'categoria_id' => 'nullable|integer|exists:categorias,id',

            'precio' => 'required|numeric|min:0.01',
        ];
    }

    public function attributes(): array
    {
        return [
            'codigo' => 'código',
            'nombre' => 'nombre',
            'descripcion' => 'descripción',
            'marca_id' => 'marca',
            'presentacione_id' => 'presentación',
            'categoria_id' => 'categoría',
            'precio' => 'precio de venta',
        ];
    }

    public function messages(): array
    {
        return [
            'precio.required' => 'El precio de venta es obligatorio.',
            'precio.numeric' => 'El precio de venta debe ser un número.',
            'precio.min' => 'El precio de venta debe ser mayor a 0.',
        ];
    }
}