@extends('layouts.app')

@section('title', 'Aperturar caja')

@push('css')
    @vite('resources/css/caja/create.css')
@endpush

@section('content')

<div class="caja-create-page">

    {{-- =====================================================
         ENCABEZADO
         ===================================================== --}}

    <div class="caja-create-header">

        <div class="caja-create-title-wrapper">

            <div class="caja-create-title-icon">
                <i class="fa-solid fa-cash-register"></i>
            </div>

            <div>
                <h1>Aperturar caja</h1>
                <p>
                    Registra el saldo inicial para comenzar las operaciones.
                </p>
            </div>

        </div>

    </div>


    {{-- =====================================================
         BREADCRUMB
         ===================================================== --}}

    <div class="caja-create-breadcrumb">

        <x-breadcrumb.template>

            <x-breadcrumb.item
                :href="route('panel')"
                content="Inicio"
            />

            <x-breadcrumb.item
                :href="route('cajas.index')"
                content="Caja"
            />

            <x-breadcrumb.item
                active="true"
                content="Aperturar caja"
            />

        </x-breadcrumb.template>

    </div>


    {{-- =====================================================
         TARJETA DEL FORMULARIO
         ===================================================== --}}

    <div class="caja-create-card">

        <div class="caja-create-card-header">

            <div class="caja-create-heading">

                <div class="caja-create-heading-icon">
                    <i class="fa-solid fa-wallet"></i>
                </div>

                <div>
                    <h5>Datos de apertura</h5>

                    <p>
                        Ingrese el efectivo disponible al iniciar la jornada.
                    </p>
                </div>

            </div>

        </div>


        <div class="caja-create-card-body">

            <x-forms.template
                :action="route('cajas.store')"
                method="post"
            >

                <div class="caja-create-form">

                    <div class="caja-create-field">

                        <x-forms.input
                            id="saldo_inicial"
                            required="true"
                            type="number"
                            labelText="Saldo inicial"
                        />

                        <small class="caja-create-help">
                            <i class="fa-solid fa-circle-info"></i>

                            Ingrese el monto de efectivo disponible
                            al momento de aperturar la caja.
                        </small>

                    </div>

                </div>


                {{-- =================================================
                     BOTONES
                     ================================================= --}}

                <x-slot name="footer">

                    <div class="caja-create-actions">

                        <a
                            href="{{ route('cajas.index') }}"
                            class="btn-caja-cancelar"
                        >
                            <i class="fa-solid fa-arrow-left"></i>
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="btn-caja-aperturar"
                        >
                            <i class="fa-solid fa-lock-open"></i>
                            Aperturar caja
                        </button>

                    </div>

                </x-slot>

            </x-forms.template>

        </div>

    </div>

</div>

@endsection


@push('js')
    @vite('resources/js/caja/create.js')
@endpush