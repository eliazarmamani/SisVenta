@extends('layouts.app')

@section('title','Inicializar producto')

@push('css')
<style>
    .producto-info {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px 18px;
    }

    .producto-info .label {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 3px;
    }

    .producto-info .nombre {
        font-size: 1.05rem;
        font-weight: 600;
        color: #212529;
    }

    .ubicacion-card {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 18px;
        background-color: #fff;
    }

    .plano-btn {
        min-width: 130px;
    }
</style>
@endpush

@section('content')

<div class="container-fluid px-4">

    <h1 class="mt-4 text-center">Inicializar Producto</h1>

    <x-breadcrumb.template>
        <x-breadcrumb.item :href="route('panel')" content="Inicio" />
        <x-breadcrumb.item :href="route('productos.index')" content="Productos" />
        <x-breadcrumb.item active="true" content="Inicializar producto" />
    </x-breadcrumb.template>

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="fa-solid fa-box-open me-2"></i>
            Configuración inicial del producto
        </div>

        <x-forms.template :action="route('inventario.store')" method="post">

            <x-slot name="header">
                <div class="producto-info">
                    <div class="label">
                        Producto seleccionado
                    </div>

                    <div class="nombre">
                        <i class="fa-solid fa-box me-2"></i>
                        {{ $producto->nombre_completo }}
                    </div>
                </div>
            </x-slot>

            {{-- ID DEL PRODUCTO --}}
            <input type="hidden"
                   name="producto_id"
                   value="{{ $producto->id }}">

            <div class="row g-4">

                {{-- UBICACIÓN --}}
                <div class="col-12">
                    <div class="ubicacion-card">

                        <label for="ubicaciones_id" class="form-label fw-semibold">
                            <i class="fa-solid fa-location-dot me-1"></i>
                            Ubicación del producto
                        </label>

                        <select name="ubicacione_id"
                                id="ubicaciones_id"
                                class="form-select"
                                required>

                            <option value="">
                                Seleccione una ubicación
                            </option>

                            @foreach ($ubicaciones as $item)

                                <option value="{{ $item->id }}"
                                    {{ old('ubicacione_id') == $item->id ? 'selected' : '' }}>

                                    {{ $item->nombre }}

                                </option>

                            @endforeach

                        </select>

                        @error('ubicacione_id')
                            <small class="text-danger d-block mt-1">
                                {{ '*' . $message }}
                            </small>
                        @enderror

                    </div>
                </div>

                {{-- VER PLANO --}}
                <div class="col-12 text-center">

                    <button type="button"
                            class="btn btn-outline-primary plano-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#verPlanoModal">

                        <i class="fa-solid fa-map me-1"></i>
                        Ver plano

                    </button>

                </div>

            </div>

            <x-slot name="footer">

                <a href="{{ route('productos.index') }}"
                   class="btn btn-secondary">

                    <i class="fa-solid fa-arrow-left me-1"></i>
                    Cancelar

                </a>

                <button type="submit"
                        class="btn btn-primary">

                    <i class="fa-solid fa-check me-1"></i>
                    Inicializar producto

                </button>

            </x-slot>

        </x-forms.template>

    </div>


    {{-- ==========================================================
         MODAL PLANO DE UBICACIONES
    =========================================================== --}}

    <div class="modal fade"
         id="verPlanoModal"
         tabindex="-1"
         aria-labelledby="verPlanoModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-xl modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-header">

                    <h1 class="modal-title fs-5"
                        id="verPlanoModalLabel">

                        <i class="fa-solid fa-map me-2"></i>
                        Plano de Ubicaciones

                    </h1>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Cerrar">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="text-center">

                        <img src="{{ asset('assets/img/plano.png') }}"
                             alt="Plano de ubicaciones"
                             class="img-fluid img-thumbnail border rounded">

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        Cerrar

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('js')
@endpush
