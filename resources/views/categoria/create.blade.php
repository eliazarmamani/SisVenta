@extends('layouts.app')

@section('title', 'Crear categoría')

@push('css')
@vite('resources/css/categoria/create.css')
@endpush

@section('content')

<div class="categoria-create-page">

<div class="container-fluid px-4">

    {{-- Encabezado --}}
    <div class="page-header">

        <div>
            <span class="page-kicker">CATEGORÍAS</span>

            <h1>Crear categoría</h1>

            <p>
                Registra una nueva categoría para organizar tus productos.
            </p>
        </div>

        <a
            href="{{ route('categorias.index') }}"
            class="btn btn-light btn-back"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Volver
        </a>

    </div>

    {{-- Breadcrumb --}}
    <x-breadcrumb.template>
        <x-breadcrumb.item
            :href="route('panel')"
            content="Inicio"
        />

        <x-breadcrumb.item
            :href="route('categorias.index')"
            content="Categorías"
        />

        <x-breadcrumb.item
            active="true"
            content="Crear categoría"
        />
    </x-breadcrumb.template>


    {{-- Formulario --}}
    <div class="categoria-form-card">

        <div class="form-card-header">

            <div class="form-title">

                <div class="form-icon">
                    <i class="fa-solid fa-tag"></i>
                </div>

                <div>
                    <h5>Nueva categoría</h5>

                    <span>
                        Completa la información solicitada
                    </span>
                </div>

            </div>

        </div>


        <div class="form-card-body">

            <x-forms.template
                :action="route('categorias.store')"
                method="post"
            >

                <div class="row g-4">

                    {{-- Nombre --}}
                    <div class="col-md-6">
                        <div class="form-field">
                            <label
                                for="nombre"
                                class="form-label-custom"
                            >
                            </label>

                            <x-forms.input
                                id="nombre"
                                required="true"
                            />

                            <small class="form-help">
                                Ingresa un nombre claro para la categoría.
                            </small>

                        </div>

                    </div>


                    {{-- Descripción --}}
                    <div class="col-12">

                        <div class="form-field">

                            <label
                                for="descripcion"
                                class="form-label-custom"
                            >
                            </label>

                            <x-forms.textarea
                                id="descripcion"
                            />

                            <small class="form-help">
                                Describe brevemente el tipo de productos
                                que pertenecerán a esta categoría.
                            </small>

                        </div>

                    </div>

                </div>


                {{-- Footer --}}
                <x-slot name="footer">

                    <div class="form-actions">

                        <a
                            href="{{ route('categorias.index') }}"
                            class="btn btn-cancel"
                        >
                            <i class="fa-solid fa-xmark"></i>
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="btn btn-save"
                        >
                            <i class="fa-solid fa-floppy-disk"></i>
                            Guardar categoría
                        </button>

                    </div>

                </x-slot>

            </x-forms.template>

        </div>

    </div>

</div>

</div>

@endsection

@push('js')
@vite('resources/js/categoria/create.js')
@endpush
