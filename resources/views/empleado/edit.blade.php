@extends('layouts.app')

@section('title', 'Editar Empleado')

@push('css')
    @vite('resources/css/empleado/edit.css')
@endpush

@section('content')

<div class="empleado-edit-page">

    <div class="container-fluid px-4">

        {{-- Encabezado --}}
        <div class="page-header">

            <div class="page-title">

                <div class="title-icon">
                    <i class="fas fa-user-edit"></i>
                </div>

                <div>
                    <h1>Editar Empleado</h1>
                    <p>Actualiza la información del empleado seleccionado.</p>
                </div>

            </div>

            <a href="{{ route('empleados.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>

        </div>

        {{-- Breadcrumb --}}
        <x-breadcrumb.template>

            <x-breadcrumb.item
                :href="route('panel')"
                content="Inicio"
            />

            <x-breadcrumb.item
                :href="route('empleados.index')"
                content="Empleados"
            />

            <x-breadcrumb.item
                active="true"
                content="Editar empleado"
            />

        </x-breadcrumb.template>

        {{-- Formulario --}}
        <x-forms.template
            :action="route('empleados.update', ['empleado' => $empleado])"
            method="post"
            patch="true"
        >

            {{-- Cabecera del formulario --}}
            <div class="form-header">

                <div class="form-header-icon">
                    <i class="fas fa-id-card"></i>
                </div>

                <div class="form-header-text">
                    <h2>Información del empleado</h2>
                    <p>Modifica los datos personales y laborales registrados.</p>
                </div>

            </div>

            {{-- Contenido --}}
            <div class="form-content">

                <div class="section-title">

                    <div class="section-icon">
                        <i class="fas fa-user"></i>
                    </div>

                    <div>
                        <h3>Datos personales y laborales</h3>
                        <span>Completa los campos obligatorios.</span>
                    </div>

                </div>

                <div class="row g-4">

                    {{-- Nombres y Apellidos --}}
                    <div class="col-md-6">

                        <div class="field-wrapper">

                            <x-forms.input
                                id="razon_social"
                                required="true"
                                labelText="Nombres y Apellidos"
                                :defaultValue="$empleado->razon_social"
                            />

                            <small class="field-help">
                                <i class="fas fa-info-circle"></i>
                                Ingresa el nombre completo del empleado.
                            </small>

                        </div>

                    </div>

                    {{-- Cargo --}}
                    <div class="col-md-6">

                        <div class="field-wrapper">

                            <x-forms.input
                                id="cargo"
                                required="true"
                                labelText="Cargo"
                                :defaultValue="$empleado->cargo"
                            />

                            <small class="field-help">
                                <i class="fas fa-briefcase"></i>
                                Indica el cargo que desempeña actualmente.
                            </small>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <x-slot name="footer">

                <div class="form-actions">

                    <a
                        href="{{ route('empleados.index') }}"
                        class="btn-cancel"
                        id="btnCancel"
                    >
                        <i class="fas fa-times"></i>
                        <span>Cancelar</span>
                    </a>

                    <button
                        type="submit"
                        class="btn-update"
                        id="btnUpdate"
                    >
                        <i class="fas fa-save"></i>
                        <span>Guardar cambios</span>
                    </button>

                </div>

            </x-slot>

        </x-forms.template>

    </div>

</div>

@endsection

@push('js')
    @vite('resources/js/empleado/edit.js')
@endpush