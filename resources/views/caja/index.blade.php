@extends('layouts.app')

@section('title', 'Caja')

@push('css-datatable') <link
     href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css"
     rel="stylesheet"
     type="text/css"
 >
@endpush

@push('css')
@vite('resources/css/caja/index.css')
@endpush

@section('content')

@if(session('success'))
    <div
        id="caja-alert"
        data-type="success"
        data-message="{{ session('success') }}"
        hidden
    ></div>
@endif

@if(session('error'))
    <div
        id="caja-alert"
        data-type="error"
        data-message="{{ session('error') }}"
        hidden
    ></div>
@endif

<div class="cajas-page">

<div class="container-fluid px-4">

    {{-- =====================================================
        ENCABEZADO
    ====================================================== --}}
    <div class="cajas-header">

        <div class="cajas-title-wrapper">

            <div class="cajas-title-icon">
                <i class="fa-solid fa-cash-register"></i>
            </div>

            <div>
                <h1>Caja</h1>
                <p>
                    Administra las aperturas, cierres y movimientos de caja.
                </p>
            </div>

        </div>

        @can('aperturar-caja')
            <a
                href="{{ route('cajas.create') }}"
                class="btn-aperturar"
            >
                <i class="fa-solid fa-plus"></i>
                <span>Aperturar caja</span>
            </a>
        @endcan

    </div>


    {{-- =====================================================
        BREADCRUMB
    ====================================================== --}}
    <div class="cajas-breadcrumb">

        <x-breadcrumb.template>

            <x-breadcrumb.item
                :href="route('panel')"
                content="Inicio"
            />

            <x-breadcrumb.item
                active="true"
                content="Caja"
            />

        </x-breadcrumb.template>

    </div>


    {{-- =====================================================
        TARJETA PRINCIPAL
    ====================================================== --}}
    <div class="cajas-card">

        {{-- CABECERA DE TABLA --}}
        <div class="cajas-card-header">

            <div class="card-heading">

                <div class="card-heading-icon">
                    <i class="fa-solid fa-table-list"></i>
                </div>

                <div>
                    <h5>Listado de caja</h5>

                    <p>
                        Consulta las aperturas, cierres y movimientos registrados.
                    </p>
                </div>

            </div>

        </div>


        {{-- CUERPO --}}
        <div class="cajas-card-body">

            <div class="table-responsive">

                <table
                    id="datatablesSimple"
                    class="cajas-table"
                >

                    <thead>

                        <tr>
                            <th>CAJA</th>
                            <th>APERTURA</th>
                            <th>CIERRE</th>
                            <th>SALDO INICIAL</th>
                            <th>SALDO FINAL</th>
                            <th>ESTADO</th>
                            <th class="text-center">ACCIONES</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($cajas as $item)

                            <tr>

                                {{-- =================================================
                                    CAJA
                                ================================================== --}}
                                <td>

                                    <div class="caja-info">

                                        <div class="caja-icon">
                                            <i class="fa-solid fa-cash-register"></i>
                                        </div>

                                        <div>

                                            <span class="caja-name">
                                                {{ $item->nombre }}
                                            </span>

                                            <small>
                                                Caja #{{ $item->id }}
                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- =================================================
                                    APERTURA
                                ================================================== --}}
                                <td>

                                    <div class="fecha-info">

                                        <div>
                                            <i class="fa-regular fa-calendar"></i>
                                            <span>
                                                {{ $item->fecha_apertura }}
                                            </span>
                                        </div>

                                        <div>
                                            <i class="fa-regular fa-clock"></i>
                                            <span>
                                                {{ $item->hora_apertura }}
                                            </span>
                                        </div>

                                    </div>

                                </td>


                                {{-- =================================================
                                    CIERRE
                                ================================================== --}}
                                <td>

                                    @if ($item->fecha_hora_cierre)

                                        <div class="fecha-info">

                                            <div>
                                                <i class="fa-regular fa-calendar"></i>
                                                <span>
                                                    {{ $item->fecha_cierre }}
                                                </span>
                                            </div>

                                            <div>
                                                <i class="fa-regular fa-clock"></i>
                                                <span>
                                                    {{ $item->hora_cierre }}
                                                </span>
                                            </div>

                                        </div>

                                    @else

                                        <span class="sin-cierre">
                                            <i class="fa-solid fa-minus"></i>
                                            Sin cierre
                                        </span>

                                    @endif

                                </td>


                                {{-- =================================================
                                    SALDO INICIAL
                                ================================================== --}}
                                <td>

                                    <span class="saldo saldo-inicial">
                                        S/
                                        {{ number_format($item->saldo_inicial, 2) }}
                                    </span>

                                </td>


                                {{-- =================================================
                                    SALDO FINAL
                                ================================================== --}}
                                <td>

                                    @if ($item->estado == 1)

                                        <span class="saldo saldo-pendiente">
                                            <i class="fa-solid fa-hourglass-half"></i>
                                            Pendiente
                                        </span>

                                    @else

                                        <span class="saldo saldo-final">
                                            S/
                                            {{ number_format($item->saldo_final, 2) }}
                                        </span>

                                    @endif

                                </td>


                                {{-- =================================================
                                    ESTADO
                                ================================================== --}}
                                <td>

                                    @if ($item->estado == 1)

                                        <span class="estado estado-abierta">

                                            <span class="estado-dot"></span>

                                            Aperturada

                                        </span>

                                    @else

                                        <span class="estado estado-cerrada">

                                            <span class="estado-dot"></span>

                                            Cerrada

                                        </span>

                                    @endif

                                </td>


                                {{-- =================================================
                                    ACCIONES
                                ================================================== --}}
                                <td>

                                    <div class="acciones">

                                        {{-- VER MOVIMIENTOS --}}
                                        @can('ver-movimiento')

                                            <form
                                                action="{{ route('movimientos.index') }}"
                                                method="GET"
                                            >

                                                <input
                                                    type="hidden"
                                                    name="caja_id"
                                                    value="{{ $item->id }}"
                                                >

                                                <button
                                                    type="submit"
                                                    class="btn-accion btn-ver"
                                                    title="Ver movimientos"
                                                >

                                                    <i class="fa-solid fa-eye"></i>

                                                    <span>
                                                        Ver
                                                    </span>

                                                </button>

                                            </form>

                                        @endcan


                                        {{-- CERRAR CAJA --}}
                                        @can('cerrar-caja')

                                            @if ($item->estado == 1)

                                                <button
                                                    type="button"
                                                    class="btn-accion btn-cerrar"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#confirmModal-{{ $item->id }}"
                                                    title="Cerrar caja"
                                                >

                                                    <i class="fa-solid fa-lock"></i>

                                                    <span>
                                                        Cerrar
                                                    </span>

                                                </button>

                                            @endif

                                        @endcan

                                    </div>

                                </td>

                            </tr>


                            {{-- =================================================
                                MODAL CERRAR CAJA
                            ================================================== --}}
                            <div
                                class="modal fade"
                                id="confirmModal-{{ $item->id }}"
                                tabindex="-1"
                                aria-hidden="true"
                            >

                                <div class="modal-dialog modal-dialog-centered">

                                    <div class="modal-content modal-caja">

                                        {{-- HEADER --}}
                                        <div class="modal-header">

                                            <div class="modal-icon-warning">
                                                <i class="fa-solid fa-lock"></i>
                                            </div>

                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Cerrar"
                                            ></button>

                                        </div>


                                        {{-- BODY --}}
                                        <div class="modal-body text-center">

                                            <h4>
                                                ¿Cerrar esta caja?
                                            </h4>

                                            <p>
                                                Estás a punto de cerrar la
                                                <strong>
                                                    {{ $item->nombre }}
                                                </strong>.
                                            </p>


                                            <div class="modal-caja-info">

                                                <div>

                                                    <span>
                                                        Saldo inicial
                                                    </span>

                                                    <strong>
                                                        S/
                                                        {{ number_format($item->saldo_inicial, 2) }}
                                                    </strong>

                                                </div>


                                                <div>

                                                    <span>
                                                        Estado actual
                                                    </span>

                                                    <strong class="text-success">
                                                        Aperturada
                                                    </strong>

                                                </div>

                                            </div>


                                            <div class="modal-alert">

                                                <i class="fa-solid fa-circle-info"></i>

                                                <span>
                                                    Una vez cerrada, la caja
                                                    quedará registrada como cerrada.
                                                </span>

                                            </div>

                                        </div>


                                        {{-- FOOTER --}}
                                        <div class="modal-footer">

                                            <button
                                                type="button"
                                                class="btn-modal-cancelar"
                                                data-bs-dismiss="modal"
                                            >
                                                Cancelar
                                            </button>


                                            <form
                                                action="{{ route('cajas.destroy', ['caja' => $item->id]) }}"
                                                method="POST"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn-modal-confirmar"
                                                >

                                                    <i class="fa-solid fa-lock"></i>

                                                    Confirmar cierre

                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</div>

@endsection

@push('js')

    <script
        src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"
        type="text/javascript"
    ></script>

    <script
        src="https://cdn.jsdelivr.net/npm/sweetalert2@11"
        type="text/javascript"
    ></script>

    @vite('resources/js/caja/index.js')

@endpush