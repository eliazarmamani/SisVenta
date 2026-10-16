@extends('layouts.app')

@section('title', 'Editar Producto')

@push('css')
<style>
    #descripcion {
        resize: none;
    }

    .precio-info {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 4px;
    }

    .precio-input {
        font-weight: 600;
    }

    .barcode-container {
        min-height: 90px;
        display: flex;
        align-items: center;
    }

    .barcode-container img {
        max-width: 100%;
        height: auto;
    }
</style>

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css"
>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endpush


@section('content')

<div class="container-fluid px-4">

    <h1 class="mt-4 text-center">Editar Producto</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('panel') }}">Inicio</a>
        </li>

        <li class="breadcrumb-item">
            <a href="{{ route('productos.index') }}">Productos</a>
        </li>

        <li class="breadcrumb-item active">
            Editar producto
        </li>
    </ol>


    <div class="card text-bg-light shadow-sm">

        <form
            action="{{ route('productos.update', ['producto' => $producto]) }}"
            method="POST"
        >

            @method('PATCH')
            @csrf


            <div class="card-body">

                {{-- =====================================================
                     INFORMACIÓN PRINCIPAL
                ====================================================== --}}

                <div class="row g-4">

                    {{-- CÓDIGO --}}
                    <div class="col-md-6">

                        <label for="codigo" class="form-label">
                            Código:
                        </label>

                        <input
                            type="text"
                            name="codigo"
                            id="codigo"
                            class="form-control"
                            value="{{ old('codigo', $producto->codigo) }}"
                        >

                        @error('codigo')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- CÓDIGO DE BARRAS --}}
                    <div class="col-md-6">

                        <p class="form-label mb-2">
                            Código de barras:
                        </p>

                        <div class="barcode-container">

                            @php
                                $codigo = $producto->codigo;
                                $generator = new Picqer\Barcode\BarcodeGeneratorPNG();

                                try {
                                    echo '<img src="data:image/png;base64,'
                                        . base64_encode(
                                            $generator->getBarcode(
                                                $codigo,
                                                $generator::TYPE_EAN_13
                                            )
                                        )
                                        . '">';
                                } catch (\Exception $e) {
                                    echo '<span class="text-danger">
                                        Formato no compatible
                                    </span>';
                                }
                            @endphp

                        </div>

                    </div>


                    {{-- NOMBRE --}}
                    <div class="col-12">

                        <label for="nombre" class="form-label">
                            Nombre:
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            id="nombre"
                            class="form-control"
                            value="{{ old('nombre', $producto->nombre) }}"
                        >

                        @error('nombre')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- DESCRIPCIÓN --}}
                    <div class="col-12">

                        <label for="descripcion" class="form-label">
                            Descripción:
                        </label>

                        <textarea
                            name="descripcion"
                            id="descripcion"
                            rows="3"
                            class="form-control"
                        >{{ old('descripcion', $producto->descripcion) }}</textarea>

                        @error('descripcion')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- =====================================================
                         PRECIO DE VENTA
                    ====================================================== --}}

                    <div class="col-md-6">

                        <label for="precio" class="form-label">
                            Precio de venta:
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                S/
                            </span>

                            <input
                                type="number"
                                name="precio"
                                id="precio"
                                class="form-control precio-input"
                                step="0.01"
                                min="0.01"
                                value="{{ old('precio', $producto->precio) }}"
                                placeholder="0.00"
                            >

                        </div>

                        <div class="precio-info">
                            <i class="fas fa-info-circle me-1"></i>
                            Precio de venta incluido IGV.
                        </div>

                        @error('precio')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>


                <hr class="my-4">


                {{-- =====================================================
                     INFORMACIÓN ADICIONAL
                ====================================================== --}}

                <div class="row g-4">

                    {{-- =================================================
                         COLUMNA ÚNICA
                    ================================================== --}}

                    <div class="col-md-6">

                        <div class="row g-4">


                            {{-- MARCA --}}
                            <div class="col-12">

                                <label for="marca_id" class="form-label">
                                    Marca:
                                </label>

                                <select
                                    data-size="4"
                                    title="Seleccione una marca"
                                    data-live-search="true"
                                    name="marca_id"
                                    id="marca_id"
                                    class="form-control selectpicker show-tick"
                                >

                                    <option value="">
                                        No tiene marca
                                    </option>

                                    @foreach ($marcas as $item)

                                        <option
                                            value="{{ $item->id }}"
                                            {{ old('marca_id', $producto->marca_id) == $item->id ? 'selected' : '' }}
                                        >
                                            {{ $item->nombre }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('marca_id')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- PRESENTACIÓN --}}
                            <div class="col-12">

                                <label for="presentacione_id" class="form-label">
                                    Presentación:
                                </label>

                                <select
                                    data-size="4"
                                    title="Seleccione una presentación"
                                    data-live-search="true"
                                    name="presentacione_id"
                                    id="presentacione_id"
                                    class="form-control selectpicker show-tick"
                                >

                                    @foreach ($presentaciones as $item)

                                        <option
                                            value="{{ $item->id }}"
                                            {{ old('presentacione_id', $producto->presentacione_id) == $item->id ? 'selected' : '' }}
                                        >
                                            {{ $item->nombre }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('presentacione_id')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- CATEGORÍA --}}
                            <div class="col-12">

                                <label for="categoria_id" class="form-label">
                                    Categoría:
                                </label>

                                <select
                                    data-size="4"
                                    title="Seleccione la categoría"
                                    data-live-search="true"
                                    name="categoria_id"
                                    id="categoria_id"
                                    class="form-control selectpicker show-tick"
                                >

                                    <option value="">
                                        No tiene categoría
                                    </option>

                                    @foreach ($categorias as $item)

                                        <option
                                            value="{{ $item->id }}"
                                            {{ old('categoria_id', $producto->categoria_id) == $item->id ? 'selected' : '' }}
                                        >
                                            {{ $item->nombre }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('categoria_id')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 BOTONES
            ====================================================== --}}

            <div class="card-footer text-center">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fas fa-save me-1"></i>
                    Actualizar producto
                </button>


                <button
                    type="reset"
                    class="btn btn-secondary"
                >
                    <i class="fas fa-undo me-1"></i>
                    Reiniciar
                </button>

            </div>

        </form>

    </div>

</div>

@endsection


@push('js')

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

@endpush