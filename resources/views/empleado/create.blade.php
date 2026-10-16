@extends('layouts.app')

@section('title', 'Crear empleado')

@push('css')
    @vite('resources/css/empleado/create.css')
@endpush

@section('content')

<div class="empleado-create-page">

    <div class="container-fluid px-4">

        {{-- ENCABEZADO --}}
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-icon">
                    <i class="fas fa-user-plus"></i>
                </div>

                <div>
                    <h1>Crear Empleado</h1>
                    <p>Registra los datos del nuevo empleado</p>
                </div>
            </div>
        </div>

        {{-- BREADCRUMB --}}
        <div class="breadcrumb-container">
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
                    content="Crear empleado"
                />
            </x-breadcrumb.template>
        </div>

        {{-- FORMULARIO --}}
        <div class="employee-card">

            <div class="employee-card-header">
                <div>
                    <h2>
                        <i class="fas fa-id-card"></i>
                        Información del empleado
                    </h2>

                    <span>
                        Completa los datos solicitados para registrar al empleado.
                    </span>
                </div>
            </div>

            <div class="employee-card-body">

                <x-forms.template
                    :action="route('empleados.store')"
                    method="post"
                >

                    <div class="row g-4">

                        {{-- NOMBRES --}}
                        <div class="col-md-6">

                            <div class="field-wrapper">

                                <label for="razon_social" class="custom-label">
                                    <i class="fas fa-user"></i>
                                    Nombres y Apellidos
                                    <span>*</span>
                                </label>

                                <x-forms.input
                                    id="razon_social"
                                    required="true"
                                    placeholder="Ej. Carlos Alberto Quispe"
                                />

                                <small class="field-help">
                                    Ingresa los nombres y apellidos completos.
                                </small>

                            </div>

                        </div>

                        {{-- CARGO --}}
                        <div class="col-md-6">

                            <div class="field-wrapper">

                                <label for="cargo" class="custom-label">
                                    <i class="fas fa-briefcase"></i>
                                    Cargo
                                    <span>*</span>
                                </label>

                                <x-forms.input
                                    id="cargo"
                                    required="true"
                                    placeholder="Ej. Vendedor"
                                />

                                <small class="field-help">
                                    Indica el cargo que desempeñará el empleado.
                                </small>

                            </div>

                        </div>

                    </div>

                    <x-slot name="footer">

                        <div class="form-footer">

                            <a
                                href="{{ route('empleados.index') }}"
                                class="btn-cancel"
                            >
                                <i class="fas fa-arrow-left"></i>
                                Cancelar
                            </a>

                            <button
                                type="submit"
                                class="btn-save"
                                id="btnGuardar"
                            >
                                <i class="fas fa-save"></i>
                                <span>Guardar empleado</span>
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
    @vite('resources/js/empleado/create.js')
@endpush