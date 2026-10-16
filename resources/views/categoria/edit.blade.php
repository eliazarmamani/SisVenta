@extends('layouts.app')

@section('title', 'Editar categoría')

@push('css')
    @vite('resources/css/categoria/edit.css')
@endpush

@section('content')

<div class="categoria-edit-page">

    <div class="container-fluid px-4">

        {{-- Encabezado --}}
        <div class="page-header">
            <div>
                <h1>
                    <i class="fas fa-tags"></i>
                    Editar Categoría
                </h1>
                <p>Actualiza la información de la categoría seleccionada.</p>
            </div>

            <a href="{{ route('categorias.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
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
                content="Editar categoría"
            />
        </x-breadcrumb.template>

        {{-- Formulario --}}
        <div class="form-card">

            <div class="form-card-header">
                <div class="header-icon">
                    <i class="fas fa-pen"></i>
                </div>

                <div>
                    <h2>Información de la categoría</h2>
                    <p>Modifica los datos necesarios y guarda los cambios.</p>
                </div>
            </div>

            <x-forms.template
                :action="route('categorias.update', ['categoria' => $categoria])"
                method="post"
                patch="true"
            >

                <div class="row g-4">

                    {{-- Nombre --}}
                    <div class="col-md-6">
                        <div class="form-field">

                            <label for="nombre">
                                Nombre de la categoría
                                <span>*</span>
                            </label>

                            <x-forms.input
                                id="nombre"
                                :defaultValue="$categoria->caracteristica->nombre"
                                required="true"
                            />

                        </div>
                    </div>

                    {{-- Descripción --}}
                    <div class="col-12">
                        <div class="form-field">

                            <label for="descripcion">
                            </label>

                            <x-forms.textarea
                                id="descripcion"
                                :defaultValue="$categoria->caracteristica->descripcion"
                            />

                            <small>
                                Describe brevemente el tipo de productos que pertenecen
                                a esta categoría.
                            </small>

                        </div>
                    </div>

                </div>

                {{-- Botones --}}
                <x-slot name="footer">

                    <div class="form-actions">

                        <button
                            type="reset"
                            class="btn-reset"
                            id="btnReset"
                        >
                            <i class="fas fa-undo"></i>
                            Reiniciar
                        </button>

                        <button
                            type="submit"
                            class="btn-update"
                        >
                            <i class="fas fa-save"></i>
                            Actualizar categoría
                        </button>

                    </div>

                </x-slot>

            </x-forms.template>

        </div>

    </div>

    {{-- Notificación de sesión --}}
    @if(session('success'))
        <div
            id="notificacion"
            data-tipo="success"
            data-mensaje="{{ session('success') }}"
            hidden>
        </div>
    @endif

    @if(session('error'))
        <div
            id="notificacion"
            data-tipo="error"
            data-mensaje="{{ session('error') }}"
            hidden>
        </div>
    @endif

    {{-- Errores de validación --}}
    @if($errors->any())
        <div
            id="errores-validacion"
            data-errores='@json($errors->all())'
            hidden>
        </div>
    @endif

</div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/js/categoria/edit.js')
@endpush