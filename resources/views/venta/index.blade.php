@extends('layouts.app')

@section('title', 'Ventas')

@push('css-datatable')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@push('css')
    <style>
        .row-not-space {
            min-width: 110px;
        }

        .venta-total {
            font-weight: 700;
            white-space: nowrap;
        }

        .venta-acciones {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        #datatablesSimple td {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-4">

        {{-- Encabezado --}}
        <h1 class="mt-4 text-center">Ventas</h1>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ route('panel') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item active">Ventas</li>
        </ol>

        {{-- Botones --}}
        @can('crear-venta')
            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="{{ route('ventas.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-1"></i>
                    Crear venta
                </a>

                <a href="{{ route('export.excel-ventas-all') }}" class="btn btn-success">
                    <i class="fa-solid fa-file-excel me-1"></i>
                    Exportar a Excel
                </a>
            </div>
        @endcan

        {{-- Tabla de ventas --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Registro de ventas
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Comprobante</th>
                                <th>Comprador</th>
                                <th>Fecha y hora</th>
                                <th>Vendedor</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($ventas as $item)
                                <tr>
                                    {{-- Comprobante --}}
                                    <td>
                                        <p class="fw-semibold mb-1">
                                            {{ $item->comprobante->tipo_comprobante ?? $item->comprobante->nombre ?? 'Comprobante' }}
                                        </p>

                                        <small class="text-muted">
                                            {{ $item->numero_comprobante }}
                                        </small>
                                    </td>

                                    {{-- Comprador --}}
                                    <td>
                                        @if ($item->cliente && $item->cliente->persona)
                                            <p class="fw-semibold mb-1">
                                                {{ $item->cliente->persona->razon_social
                                                    ?: trim(($item->cliente->persona->nombres ?? '') . ' ' . ($item->cliente->persona->apellidos ?? ''))
                                                    ?: 'Cliente registrado' }}
                                            </p>

                                            <small class="text-muted">
                                                {{ $item->cliente->persona->numero_documento ?? '' }}
                                            </small>

                                        @elseif ($item->razon_social_cliente)
                                            <p class="fw-semibold mb-1">
                                                {{ $item->razon_social_cliente }}
                                            </p>

                                            <small class="text-muted">
                                                RUC: {{ $item->numero_documento_cliente ?? '' }}
                                            </small>

                                        @elseif ($item->numero_documento_cliente)
                                            <p class="fw-semibold mb-1">
                                                {{ trim(($item->nombres_cliente ?? '') . ' ' . ($item->apellidos_cliente ?? '')) ?: 'Comprador' }}
                                            </p>

                                            <small class="text-muted">
                                                {{ $item->tipo_documento_cliente ?? 'Documento' }}:
                                                {{ $item->numero_documento_cliente }}
                                            </small>

                                        @else
                                            <span class="text-muted">
                                                Sin datos del comprador
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Fecha y hora --}}
                                    <td>
                                        <div class="row-not-space">
                                            <p class="fw-semibold mb-1">
                                                <i class="fa-solid fa-calendar-days me-1"></i>
                                                {{ $item->fecha }}
                                            </p>

                                            <p class="text-muted mb-0">
                                                <i class="fa-solid fa-clock me-1"></i>
                                                {{ $item->hora }}
                                            </p>
                                        </div>
                                    </td>

                                    {{-- Vendedor --}}
                                    <td>
                                        {{ $item->user->name ?? 'Usuario no disponible' }}
                                    </td>

                                    {{-- Total --}}
                                    <td class="venta-total">
                                        S/ {{ number_format((float) $item->total, 2) }}
                                    </td>

                                    {{-- Acciones --}}
                                    <td>
                                        <div class="venta-acciones">

                                            @can('mostrar-venta')
                                                <a href="{{ route('ventas.show', ['venta' => $item]) }}"
                                                   class="btn btn-success btn-sm">
                                                    <i class="fa-solid fa-eye me-1"></i>
                                                    Ver
                                                </a>
                                            @endcan

                                            <a href="{{ route('export.pdf-comprobante-venta', ['id' => Crypt::encrypt($item->id)]) }}"
                                               class="btn btn-secondary btn-sm"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <i class="fa-solid fa-file-pdf me-1"></i>
                                                PDF
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const tabla = document.querySelector('#datatablesSimple');

            if (tabla && typeof simpleDatatables !== 'undefined') {
                new simpleDatatables.DataTable(tabla, {
                    perPage: 8,
                    perPageSelect: [5, 8, 10, 15, 20],
                    labels: {
                        placeholder: 'Buscar...',
                        perPage: '{select} registros por página',
                        noRows: 'No hay ventas registradas',
                        info: 'Mostrando {start} a {end} de {rows} ventas',
                        noResults: 'No se encontraron resultados'
                    }
                });
            }
        });
    </script>
@endpush