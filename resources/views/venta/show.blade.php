@extends('layouts.app')

@section('title', 'Ver venta')

@push('css')
    <style>
        .venta-info {
            height: 100%;
            padding: 14px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background-color: var(--bs-tertiary-bg);
        }

        .venta-info .info-label {
            display: block;
            margin-bottom: 5px;
            color: var(--bs-secondary-color);
            font-size: 0.85rem;
        }

        .venta-info .info-value {
            margin-bottom: 0;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .venta-total {
            font-size: 1.05rem;
            font-weight: 700;
        }

        .tabla-productos th,
        .tabla-productos td {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-4">

        {{-- Encabezado --}}
        <h1 class="mt-4 text-center">Detalle de la venta</h1>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ route('panel') }}">Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('ventas.index') }}">Ventas</a>
            </li>
            <li class="breadcrumb-item active">Detalle de venta</li>
        </ol>

        {{-- Datos generales --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <i class="fa-solid fa-receipt me-1"></i>
                Datos generales de la venta
            </div>

            <div class="card-body">
                <div class="row g-3">

                    {{-- Comprobante --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="venta-info">
                            <span class="info-label">Comprobante</span>
                            <p class="info-value">
                                {{ $venta->comprobante->nombre ?? 'No disponible' }}
                            </p>
                            <small class="text-muted">
                                N.º {{ $venta->numero_comprobante }}
                            </small>
                        </div>
                    </div>

                    {{-- Comprador --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="venta-info">
                            <span class="info-label">Comprador</span>

                            @if ($venta->cliente && $venta->cliente->persona)
                                <p class="info-value">
                                    {{ $venta->cliente->persona->razon_social
                                        ?: trim(($venta->cliente->persona->nombres ?? '') . ' ' . ($venta->cliente->persona->apellidos ?? ''))
                                        ?: 'Cliente registrado' }}
                                </p>

                                <small class="text-muted">
                                    {{ $venta->cliente->persona->numero_documento ?? '' }}
                                </small>

                            @elseif ($venta->razon_social_cliente)
                                <p class="info-value">
                                    {{ $venta->razon_social_cliente }}
                                </p>
                                <small class="text-muted">
                                    RUC: {{ $venta->numero_documento_cliente ?? '' }}
                                </small>

                            @elseif ($venta->numero_documento_cliente)
                                <p class="info-value">
                                    {{ trim(($venta->nombres_cliente ?? '') . ' ' . ($venta->apellidos_cliente ?? '')) ?: 'Comprador' }}
                                </p>
                                <small class="text-muted">
                                    {{ $venta->tipo_documento_cliente ?? 'Documento' }}:
                                    {{ $venta->numero_documento_cliente }}
                                </small>

                            @else
                                <p class="info-value text-muted">
                                    Sin datos del comprador
                                </p>
                            @endif

                            @if ($venta->direccion_cliente)
                                <small class="text-muted d-block mt-1">
                                    {{ $venta->direccion_cliente }}
                                </small>
                            @endif
                        </div>
                    </div>

                    {{-- Vendedor --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="venta-info">
                            <span class="info-label">Vendedor</span>
                            <p class="info-value">
                                {{ $venta->user->name ?? 'Usuario no disponible' }}
                            </p>
                        </div>
                    </div>

                    {{-- Método de pago --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="venta-info">
                            <span class="info-label">Método de pago</span>
                            <p class="info-value">
                                {{ $venta->metodo_pago }}
                            </p>
                        </div>
                    </div>

                    {{-- Fecha --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="venta-info">
                            <span class="info-label">Fecha</span>
                            <p class="info-value">{{ $venta->fecha }}</p>
                        </div>
                    </div>

                    {{-- Hora --}}
                    <div class="col-md-6 col-lg-4">
                        <div class="venta-info">
                            <span class="info-label">Hora</span>
                            <p class="info-value">{{ $venta->hora }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Detalle de productos --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Productos de la venta
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover tabla-productos">
                        <thead class="table-primary">
                            <tr>
                                <th>Producto</th>
                                <th>Presentación</th>
                                <th class="text-end">Cantidad</th>
                                <th class="text-end">Precio unitario</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($venta->productos as $item)
                                <tr>
                                    <td>{{ $item->nombre }}</td>

                                    <td>
                                        {{ $item->presentacione->sigla ?? '—' }}
                                    </td>

                                    <td class="text-end">
                                        {{ $item->pivot->cantidad }}
                                    </td>

                                    <td class="text-end">
                                        {{ $empresa->moneda->simbolo ?? 'S/' }}
                                        {{ number_format((float) $item->pivot->precio_venta, 2) }}
                                    </td>

                                    <td class="text-end">
                                        {{ $empresa->moneda->simbolo ?? 'S/' }}
                                        {{ number_format(
                                            (float) $item->pivot->cantidad * (float) $item->pivot->precio_venta,
                                            2
                                        ) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        No hay productos registrados en esta venta.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        {{-- Totales --}}
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Subtotal:</th>
                                <th class="text-end">
                                    {{ $empresa->moneda->simbolo ?? 'S/' }}
                                    {{ number_format((float) $venta->subtotal, 2) }}
                                </th>
                            </tr>

                            <tr>
                                <th colspan="4" class="text-end">
                                    {{ $empresa->abreviatura_impuesto ?? 'Impuesto' }}
                                    ({{ $empresa->porcentaje_impuesto ?? 0 }}%):
                                </th>
                                <th class="text-end">
                                    {{ $empresa->moneda->simbolo ?? 'S/' }}
                                    {{ number_format((float) $venta->impuesto, 2) }}
                                </th>
                            </tr>

                            <tr class="table-primary">
                                <th colspan="4" class="text-end">TOTAL:</th>
                                <th class="text-end venta-total">
                                    {{ $empresa->moneda->simbolo ?? 'S/' }}
                                    {{ number_format((float) $venta->total, 2) }}
                                </th>
                            </tr>

                            <tr>
                                <th colspan="4" class="text-end">Monto recibido:</th>
                                <th class="text-end">
                                    {{ $empresa->moneda->simbolo ?? 'S/' }}
                                    {{ number_format((float) $venta->monto_recibido, 2) }}
                                </th>
                            </tr>

                            <tr>
                                <th colspan="4" class="text-end">Vuelto:</th>
                                <th class="text-end">
                                    {{ $empresa->moneda->simbolo ?? 'S/' }}
                                    {{ number_format((float) $venta->vuelto_entregado, 2) }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i>
                    Volver a ventas
                </a>
            </div>
        </div>

    </div>
@endsection