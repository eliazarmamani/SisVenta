@extends('layouts.app')

@section('title', 'Mi empresa')

@push('css')
    @vite('resources/css/empresa/index.css')
@endpush

@section('content')
{{-- MENSAJES DEL SISTEMA --}} 
@if(session('success')) 
    <div id="empresa-alert" data-type="success" data-message="{{ session('success') }}" hidden >
    </div> 
@endif 
@if(session('error')) 
    <div id="empresa-alert" data-type="error" data-message="{{ session('error') }}" hidden >
    </div> 
@endif
<div class="empresa-page">

    <div class="container-fluid px-4">

        {{-- Encabezado --}}
        <div class="empresa-header">
            <div>
                <h1>
                    <i class="fas fa-building"></i>
                    Mi empresa
                </h1>
                <p>Administra la información general de tu empresa</p>
            </div>
        </div>

        {{-- Breadcrumb --}}
        <x-breadcrumb.template>
            <x-breadcrumb.item
                :href="route('panel')"
                content="Inicio"
            />

            <x-breadcrumb.item
                active="true"
                content="Mi empresa"
            />
        </x-breadcrumb.template>

        {{-- Formulario --}}
        <div class="empresa-card">

            <div class="empresa-card-header">
                <div class="header-icon">
                    <i class="fas fa-building"></i>
                </div>

                <div>
                    <h2>Información de la empresa</h2>
                    <p>Actualiza los datos utilizados por el sistema.</p>
                </div>
            </div>

            <div class="empresa-card-body">

                <x-forms.template
                    :action="route('empresa.update', ['empresa' => $empresa])"
                    method="post"
                    patch="true"
                >

                    <div class="row g-4">

                        {{-- Información principal --}}
                        <div class="col-12">
                            <div class="section-title">
                                <i class="fas fa-id-card"></i>
                                <span>Información principal</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <x-forms.input
                                id="nombre"
                                labelText="Nombre de la empresa"
                                required="true"
                                :defaultValue="$empresa->nombre"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-forms.input
                                id="propietario"
                                labelText="Propietario"
                                required="true"
                                :defaultValue="$empresa->propietario"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-forms.input
                                id="ruc"
                                labelText="RUC"
                                required="true"
                                :defaultValue="$empresa->ruc"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-forms.input
                                id="direccion"
                                labelText="Dirección"
                                required="true"
                                :defaultValue="$empresa->direccion"
                            />
                        </div>


                        {{-- Impuestos --}}
                        <div class="col-12 mt-4">
                            <div class="section-title">
                                <i class="fas fa-percent"></i>
                                <span>Configuración de impuestos</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <x-forms.input
                                id="porcentaje_impuesto"
                                labelText="Porcentaje del impuesto (%)"
                                required="true"
                                :defaultValue="$empresa->porcentaje_impuesto"
                                type="number"
                                step="0.01"
                                min="0"
                            />
                        </div>

                        <div class="col-md-6">
                            <x-forms.input
                                id="abreviatura_impuesto"
                                labelText="Abreviatura del impuesto"
                                required="true"
                                :defaultValue="$empresa->abreviatura_impuesto"
                            />
                        </div>


                        {{-- Contacto --}}
                        <div class="col-12 mt-4">
                            <div class="section-title">
                                <i class="fas fa-address-book"></i>
                                <span>Información de contacto</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <x-forms.input
                                id="correo"
                                labelText="Correo electrónico"
                                :defaultValue="$empresa->correo"
                                type="email"
                            />
                        </div>

                        <div class="col-md-4">
                            <x-forms.input
                                id="telefono"
                                labelText="Teléfono"
                                :defaultValue="$empresa->telefono"
                            />
                        </div>

                        <div class="col-md-4">
                            <x-forms.input
                                id="ubicacion"
                                labelText="Ubicación"
                                :defaultValue="$empresa->ubicacion"
                            />
                        </div>


                        {{-- Moneda --}}
                        <div class="col-12 mt-4">

                            <div class="section-title">
                                <i class="fas fa-coins"></i>
                                <span>Configuración monetaria</span>
                            </div>

                            <label
                                for="moneda_id"
                                class="form-label empresa-label"
                            >
                                Moneda del sistema
                            </label>

                            <select
                                name="moneda_id"
                                id="moneda_id"
                                class="form-select empresa-select"
                            >
                                @foreach ($monedas as $moneda)
                                    <option
                                        value="{{ $moneda->id }}"
                                        {{ $empresa->moneda_id == $moneda->id || old('moneda_id') == $moneda->id ? 'selected' : '' }}
                                    >
                                        {{ $moneda->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>

                            @error('moneda_id')
                                <small class="text-danger error-text">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                    </div>

                    {{-- Botón --}}
                    @can('update-empresa')
                        <x-slot name="footer">

                            <div class="empresa-footer">

                                <button
                                    type="submit"
                                    class="btn btn-primary btn-empresa"
                                >
                                    <i class="fas fa-save"></i>
                                    Actualizar información
                                </button>

                            </div>

                        </x-slot>
                    @endcan

                </x-forms.template>

            </div>

        </div>

    </div>

</div>

@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" 
        type="text/javascript" >
</script>

@push('js')
    @vite('resources/js/empresa/index.js')
@endpush