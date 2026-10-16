@extends('layouts.app')

@section('title', 'Kardex')

@push('css-datatable')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endpush

@push('css')
<style>
    .kardex-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .kardex-card .card-header {
        background: #fff;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 1.25rem;
    }

    .kardex-title {
        font-weight: 600;
        color: #343a40;
    }

    .kardex-table {
        vertical-align: middle;
        white-space: nowrap;
    }

    .kardex-table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        font-size: 0.88rem;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }

    .kardex-table tbody td {
        font-size: 0.88rem;
    }

    .kardex-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .movimiento-compra {
        color: #198754;
        font-weight: 600;
    }

    .movimiento-venta {
        color: #dc3545;
        font-weight: 600;
    }

    .cantidad-entrada {
        color: #198754;
        font-weight: 600;
    }

    .cantidad-salida {
        color: #dc3545;
        font-weight: 600;
    }

    .saldo {
        font-weight: 700;
    }

    .valor-saldo {
        font-weight: 700;
    }

    .filtro-kardex {
        background: #fff;
        border-radius: 10px;
        padding: 1rem;
        border: 1px solid #e9ecef;
    }
</style>
@endpush

@section('content')

<div class="container-fluid px-4">

    <h1 class="mt-4 text-center">Kardex</h1>

    <x-breadcrumb.template>
        <x-breadcrumb.item :href="route('panel')" content="Inicio" />
        <x-breadcrumb.item active="true" content="Kardex" />
    </x-breadcrumb.template>

    {{-- FILTRO DE PRODUCTO --}}
    <div class="filtro-kardex mb-4">

        <form action="{{ route('kardex.index') }}" method="GET">

            <div class="row gy-2 align-items-center">

                <label for="producto_id" class="col-sm-2 col-form-label fw-semibold">
                    Producto
                </label>

                <div class="col-sm-8">

                    <select
                        name="producto_id"
                        id="producto_id"
                        class="form-control selectpicker"
                        data-live-search="true"
                        data-size="5"
                        title="Busque un producto aquí">

                        @foreach ($productos as $item)

                            <option
                                value="{{ $item->id }}"
                                {{ $item->id == $producto_id ? 'selected' : '' }}>

                                {{ $item->nombre_completo }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-sm-2">

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i>
                        Buscar
                    </button>

                </div>

            </div>

        </form>

    </div>


    @if ($kardex->count())

        @php
            /*
            |--------------------------------------------------------------------------
            | CÁLCULO DEL VALOR DEL SALDO
            |--------------------------------------------------------------------------
            |
            | Recorremos el Kardex desde el movimiento más antiguo hasta el más
            | reciente para conocer cuánto vale el inventario después de cada
            | movimiento.
            |
            | Compra:
            |   valor saldo = valor anterior + costo de la entrada
            |
            | Venta:
            |   valor saldo = valor anterior - costo de la salida
            |
            */

            $valorSaldo = 0;
            $valoresSaldo = [];

            foreach ($kardex->reverse() as $movimiento) {

                $entrada = (float) ($movimiento->entrada ?? 0);
                $salida = (float) ($movimiento->salida ?? 0);
                $costoUnitario = (float) ($movimiento->costo_unitario ?? 0);

                $valorMovimiento = 0;

                if ($entrada > 0) {
                    $valorMovimiento = $entrada * $costoUnitario;
                    $valorSaldo += $valorMovimiento;
                }

                if ($salida > 0) {
                    $valorMovimiento = $salida * $costoUnitario;
                    $valorSaldo -= $valorMovimiento;
                }

                $valoresSaldo[$movimiento->id] = $valorSaldo;
            }
        @endphp


        {{-- TABLA --}}
        <div class="card kardex-card shadow-sm">

            <div class="card-header">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <div class="kardex-title">
                            <i class="fas fa-boxes-stacked me-2"></i>
                            Kardex del producto
                        </div>

                        <small class="text-muted">
                            Control de entradas, salidas, costos y valor del inventario
                        </small>
                    </div>

                </div>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table id="datatablesSimple"
                        class="table table-striped table-hover kardex-table">

                        <thead>

                            <tr>

                                <th>Fecha y hora</th>

                                <th>Transacción</th>

                                <th>Descripción</th>

                                <th class="text-center">Entrada</th>

                                <th class="text-center">Salida</th>

                                <th class="text-center">Saldo</th>

                                <th class="text-end">Costo unitario</th>

                                <th class="text-end">Costo movimiento</th>

                                <th class="text-end">Valor del saldo</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($kardex as $item)

                                @php

                                    $entrada = (float) ($item->entrada ?? 0);
                                    $salida = (float) ($item->salida ?? 0);
                                    $costoUnitario = (float) ($item->costo_unitario ?? 0);

                                    $cantidadMovimiento = $entrada > 0
                                        ? $entrada
                                        : $salida;

                                    $costoMovimiento = $cantidadMovimiento * $costoUnitario;

                                    $valorSaldoActual = $valoresSaldo[$item->id] ?? 0;

                                @endphp

                                <tr>

                                    {{-- FECHA --}}
                                    <td>
                                        <div class="fw-semibold">
                                            {{ $item->fecha }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $item->hora }}
                                        </small>
                                    </td>


                                    {{-- TRANSACCIÓN --}}
                                    <td>

                                        @if ($item->tipo_transaccion == 'COMPRA')

                                            <span class="movimiento-compra">
                                                <i class="fas fa-arrow-down me-1"></i>
                                                COMPRA
                                            </span>

                                        @elseif ($item->tipo_transaccion == 'VENTA')

                                            <span class="movimiento-venta">
                                                <i class="fas fa-arrow-up me-1"></i>
                                                VENTA
                                            </span>

                                        @else

                                            <span class="fw-semibold">
                                                {{ $item->tipo_transaccion }}
                                            </span>

                                        @endif

                                    </td>


                                    {{-- DESCRIPCIÓN --}}
                                    <td>
                                        {{ $item->descripcion_transaccion }}
                                    </td>


                                    {{-- ENTRADA --}}
                                    <td class="text-center">

                                        @if ($entrada > 0)

                                            <span class="cantidad-entrada">
                                                +{{ number_format($entrada, 0) }}
                                            </span>

                                        @else

                                            <span class="text-muted">—</span>

                                        @endif

                                    </td>


                                    {{-- SALIDA --}}
                                    <td class="text-center">

                                        @if ($salida > 0)

                                            <span class="cantidad-salida">
                                                -{{ number_format($salida, 0) }}
                                            </span>

                                        @else

                                            <span class="text-muted">—</span>

                                        @endif

                                    </td>


                                    {{-- SALDO --}}
                                    <td class="text-center">

                                        <span class="saldo">
                                            {{ number_format($item->saldo, 0) }}
                                        </span>

                                    </td>


                                    {{-- COSTO UNITARIO --}}
                                    <td class="text-end">

                                        S/ {{ number_format($costoUnitario, 2) }}

                                    </td>


                                    {{-- COSTO DEL MOVIMIENTO --}}
                                    <td class="text-end">

                                        <span class="fw-semibold">
                                            S/ {{ number_format($costoMovimiento, 2) }}
                                        </span>

                                    </td>


                                    {{-- VALOR DEL SALDO --}}
                                    <td class="text-end">

                                        <span class="valor-saldo">
                                            S/ {{ number_format($valorSaldoActual, 2) }}
                                        </span>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @else

        <div class="text-center my-5">

            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>

            <h5 class="text-muted">
                Sin movimientos de Kardex
            </h5>

            <p class="text-muted mb-0">
                Seleccione un producto para consultar sus movimientos.
            </p>

        </div>

    @endif

</div>

@endsection


@push('js')

<script
    src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"
    type="text/javascript">
</script>

<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js">
</script>

<script>
    $(document).ready(function () {
        $('.selectpicker').selectpicker();
    });
</script>

@endpush