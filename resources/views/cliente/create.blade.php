@extends('layouts.app')

@section('title', 'Crear cliente')

@push('css')
    @vite('resources/css/cliente/create.css')
@endpush

@section('content')

<div class="cliente-create-page">

    <div class="container-fluid px-4">

        {{-- ENCABEZADO --}}
        <div class="page-header">
            <div>
                <h1>
                    <i class="fas fa-user-plus"></i>
                    Crear cliente
                </h1>

                <p>
                    Registra la información del nuevo cliente
                </p>
            </div>
        </div>


        {{-- BREADCRUMB --}}
        <ol class="breadcrumb custom-breadcrumb">

            <li class="breadcrumb-item">
                <a href="{{ route('panel') }}">
                    <i class="fas fa-home"></i>
                    Inicio
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('clientes.index') }}">
                    Clientes
                </a>
            </li>

            <li class="breadcrumb-item active">
                Crear cliente
            </li>

        </ol>


        {{-- FORMULARIO --}}
        <div class="card cliente-form-card">

            {{-- CABECERA DEL FORMULARIO --}}
            <div class="card-header">

                <div class="form-title">

                    <div class="form-icon">
                        <i class="fas fa-user"></i>
                    </div>

                    <div>
                        <h5>Información del cliente</h5>

                        <span>
                            Completa los datos solicitados
                        </span>
                    </div>

                </div>

            </div>


            <form
                action="{{ route('clientes.store') }}"
                method="POST"
            >

                @csrf

                <div class="card-body">

                    {{-- =================================================
                         DATOS PRINCIPALES
                    ================================================== --}}
                    <div class="section-title">
                        <i class="fas fa-id-card"></i>
                        Datos principales
                    </div>


                    <div class="row g-4">

                        {{-- TIPO DE CLIENTE --}}
                        <div class="col-md-6">

                            <label
                                for="tipo"
                                class="form-label"
                            >
                                Tipo de cliente
                                <span class="required">*</span>
                            </label>

                            <select
                                name="tipo"
                                id="tipo"
                                class="form-select @error('tipo') is-invalid @enderror"
                            >

                                <option
                                    value=""
                                    selected
                                    disabled
                                >
                                    Seleccione una opción
                                </option>

                                @foreach ($optionsTipoPersona as $item)

                                    <option
                                        value="{{ $item->value }}"
                                        {{ old('tipo') == $item->value ? 'selected' : '' }}
                                    >
                                        {{ $item->name }}
                                    </option>

                                @endforeach

                            </select>

                            @error('tipo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- TIPO DE DOCUMENTO --}}
                        <div class="col-md-6">

                            <label
                                for="documento_id"
                                class="form-label"
                            >
                                Tipo de documento
                                <span class="required">*</span>
                            </label>

                            <select
                                name="documento_id"
                                id="documento_id"
                                class="form-select @error('documento_id') is-invalid @enderror"
                            >

                                <option
                                    value=""
                                    selected
                                    disabled
                                >
                                    Seleccione una opción
                                </option>

                                @foreach ($documentos as $item)

                                    <option
                                        value="{{ $item->id }}"
                                        {{ old('documento_id') == $item->id ? 'selected' : '' }}
                                    >
                                        {{ $item->nombre }}
                                    </option>

                                @endforeach

                            </select>

                            @error('documento_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- NÚMERO DE DOCUMENTO --}}
                        <div class="col-md-6">

                            <label
                                for="numero_documento"
                                class="form-label"
                            >
                                Número de documento
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="numero_documento"
                                id="numero_documento"
                                class="form-control @error('numero_documento') is-invalid @enderror"
                                value="{{ old('numero_documento') }}"
                                placeholder="Ingrese el número de documento"
                            >

                            @error('numero_documento')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- NOMBRE / EMPRESA --}}
                        <div
                            class="col-md-6"
                            id="box-razon-social"
                        >

                            {{-- PERSONA NATURAL --}}
                            <label
                                id="label-natural"
                                for="razon_social"
                                class="form-label"
                            >
                                Nombres y apellidos
                                <span class="required">*</span>
                            </label>


                            {{-- PERSONA JURÍDICA --}}
                            <label
                                id="label-juridica"
                                for="razon_social"
                                class="form-label d-none"
                            >
                                Nombre de la empresa
                                <span class="required">*</span>
                            </label>


                            <input
                                type="text"
                                name="razon_social"
                                id="razon_social"
                                class="form-control @error('razon_social') is-invalid @enderror"
                                value="{{ old('razon_social') }}"
                                placeholder="Ingrese el nombre"
                            >

                            @error('razon_social')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    {{-- =================================================
                         INFORMACIÓN DE CONTACTO
                    ================================================== --}}
                    <div class="section-title section-contact">

                        <i class="fas fa-address-book"></i>

                        Información de contacto

                    </div>


                    <div class="row g-4">

                        {{-- DIRECCIÓN --}}
                        <div class="col-12">

                            <label
                                for="direccion"
                                class="form-label"
                            >
                                Dirección
                            </label>

                            <input
                                type="text"
                                name="direccion"
                                id="direccion"
                                class="form-control @error('direccion') is-invalid @enderror"
                                value="{{ old('direccion') }}"
                                placeholder="Ingrese la dirección"
                            >

                            @error('direccion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- CORREO ELECTRÓNICO --}}
                        <div class="col-md-6">

                            <x-forms.input
                                id="email"
                                type="email"
                                labelText="Correo electrónico"
                            />

                        </div>


                        {{-- TELÉFONO --}}
                        <div class="col-md-6">

                            <x-forms.input
                                id="telefono"
                                type="tel"
                                labelText="Teléfono"
                            />

                        </div>

                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="card-footer form-footer">

                    <a
                        href="{{ route('clientes.index') }}"
                        class="btn btn-secondary"
                    >
                        <i class="fas fa-arrow-left"></i>
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="fas fa-save"></i>
                        Guardar cliente
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


@push('js')
    @vite('resources/js/cliente/create.js')
@endpush