
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $venta->comprobante->nombre ?? 'Comprobante' }} - {{ $venta->numero_comprobante }}
    </title>

    <style>
        @page {
            size: 72mm 100mm;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 72mm;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9.5px;
            color: #000;
            background: #fff;
        }

        .boleta {
            width: 69mm;
            margin-left: 1.5mm;
            padding: 0.5mm 1mm;
        }

        .empresa {
            width: 68mm;
            text-align: center;
            margin-bottom: 0.7mm;
        }

        .empresa h1 {
            font-size: 12px;
            font-weight: bold;
            margin: 0 0 0.5mm;
            line-height: 1.15;
            overflow-wrap: break-word;
        }

        .empresa p {
            font-size: 8.5px;
            margin: 0.2mm 0;
            line-height: 1.15;
            overflow-wrap: break-word;
        }

        .comprobante {
            width: 68mm;
            text-align: center;
            border-top: 0.5px solid #000;
            border-bottom: 0.5px solid #000;
            padding: 0.7mm 0;
            margin-bottom: 0.7mm;
        }

        .comprobante strong {
            display: block;
            font-size: 11px;
            line-height: 1.15;
        }

        .comprobante span {
            display: block;
            font-size: 9.5px;
            margin-top: 0.3mm;
            line-height: 1.15;
        }

        .datos {
            width: 68mm;
            margin-bottom: 0.7mm;
        }

        .fila {
            width: 68mm;
            display: flex;
            margin-bottom: 0.4mm;
            line-height: 1.15;
            font-size: 9px;
        }

        .fila .label {
            width: 17mm;
            font-weight: bold;
            flex-shrink: 0;
        }

        .fila .valor {
            width: 51mm;
            overflow-wrap: anywhere;
        }

        table {
            width: 68mm;
            border-collapse: collapse;
            table-layout: fixed;
            margin: 0;
        }

        thead {
            border-top: 0.5px solid #000;
            border-bottom: 0.5px solid #000;
        }

        th {
            font-size: 8.5px;
            font-weight: bold;
            padding: 0.5mm 0.2mm;
            line-height: 1.1;
            text-align: center;
        }

        td {
            font-size: 9px;
            padding: 0.45mm 0.2mm;
            line-height: 1.15;
            vertical-align: top;
            overflow-wrap: anywhere;
        }

        .col-cantidad {
            width: 8mm;
            text-align: center;
        }

        .col-producto {
            width: 31mm;
            text-align: left;
        }

        .col-precio {
            width: 14mm;
            text-align: right;
        }

        .col-total {
            width: 15mm;
            text-align: right;
        }

        .totales {
            width: 68mm;
            margin-top: 0.8mm;
            padding-top: 0.5mm;
            border-top: 0.5px solid #000;
        }

        .total-fila {
            width: 68mm;
            display: flex;
            justify-content: space-between;
            gap: 2mm;
            margin-bottom: 0.5mm;
            line-height: 1.15;
            font-size: 9px;
        }

        .total-fila .nombre {
            font-weight: bold;
        }

        .total-fila .valor {
            text-align: right;
        }

        .total-final {
            width: 68mm;
            display: flex;
            justify-content: space-between;
            gap: 2mm;
            border-top: 0.5px solid #000;
            margin-top: 0.6mm;
            padding-top: 0.6mm;
            font-size: 11px;
            font-weight: bold;
            line-height: 1.15;
        }

        .pago {
            width: 68mm;
            margin-top: 0.8mm;
            font-size: 9px;
            line-height: 1.2;
            overflow-wrap: anywhere;
        }

        .pago strong {
            font-weight: bold;
        }

        .pie {
            width: 68mm;
            text-align: center;
            margin-top: 1mm;
            padding-top: 0.6mm;
            border-top: 0.4px solid #000;
            font-size: 8.5px;
            line-height: 1.2;
        }

        .pie p {
            margin: 0.3mm 0;
        }

        .gracias {
            font-weight: bold;
            font-size: 10px;
            margin-top: 0.4mm !important;
        }

        @media print {
            @page {
                size: 72mm 100mm;
                margin: 0;
            }

            html,
            body {
                width: 72mm;
                margin: 0;
                padding: 0;
            }

            .boleta {
                width: 69mm;
                margin-left: 1.5mm;
                padding: 0.5mm 1mm;
            }
        }
    </style>
</head>

<body>

    @php
        $persona = $venta->cliente?->persona;
        $documento = $persona?->documento;

        $simboloMoneda = $empresa->moneda->simbolo ?? 'S/';

        // Datos del comprador guardados directamente en la venta.
        $nombreComprador = trim(
            ($venta->nombres_cliente ?? '') . ' ' .
            ($venta->apellidos_cliente ?? '')
        );

        // Si existe un cliente registrado, priorizamos sus datos.
        $nombreClienteRegistrado = $persona?->razon_social
            ?: trim(($persona?->nombres ?? '') . ' ' . ($persona?->apellidos ?? ''));

        $nombreComprador = $nombreClienteRegistrado
            ?: ($venta->razon_social_cliente ?: $nombreComprador);

        $numeroDocumento = $persona?->numero_documento
            ?: $venta->numero_documento_cliente;

        $tipoDocumento = $documento?->nombre
            ?: ($venta->tipo_documento_cliente ?? 'Documento');

        $direccionComprador = $persona?->direccion
            ?: $venta->direccion_cliente;
    @endphp

    <div class="boleta">

        {{-- EMPRESA --}}
        <div class="empresa">
            <h1>{{ $empresa->nombre ?? 'Empresa' }}</h1>

            @if ($empresa->ruc)
                <p>RUC: {{ $empresa->ruc }}</p>
            @endif

            @if ($empresa->direccion)
                <p>{{ $empresa->direccion }}</p>
            @endif

            @if ($empresa->ubicacion)
                <p>{{ $empresa->ubicacion }}</p>
            @endif

            @if ($empresa->telefono)
                <p>Tel: {{ $empresa->telefono }}</p>
            @endif

            @if ($empresa->correo)
                <p>{{ $empresa->correo }}</p>
            @endif
        </div>

        {{-- COMPROBANTE --}}
        <div class="comprobante">
            <strong>
                {{ $venta->comprobante->nombre ?? 'Comprobante de venta' }}
            </strong>

            <span>
                N.º {{ $venta->numero_comprobante ?? 'Sin número' }}
            </span>
        </div>

        {{-- DATOS DEL COMPRADOR --}}
        <div class="datos">

            <div class="fila">
                <div class="label">Cliente:</div>

                <div class="valor">
                    {{ $nombreComprador ?: 'Consumidor final' }}
                </div>
            </div>

            <div class="fila">
                <div class="label">
                    {{ strtoupper($tipoDocumento) }}:
                </div>

                <div class="valor">
                    {{ $numeroDocumento ?: 'No registrado' }}
                </div>
            </div>

            @if ($direccionComprador)
                <div class="fila">
                    <div class="label">Dirección:</div>

                    <div class="valor">
                        {{ $direccionComprador }}
                    </div>
                </div>
            @endif

            <div class="fila">
                <div class="label">Fecha:</div>

                <div class="valor">
                    {{ $venta->fecha_hora
                        ? \Carbon\Carbon::parse($venta->fecha_hora)->format('d/m/Y H:i')
                        : 'No registrada' }}
                </div>
            </div>

        </div>

        {{-- PRODUCTOS --}}
        <table>
            <thead>
                <tr>
                    <th class="col-cantidad">Cant.</th>
                    <th class="col-producto">Producto</th>
                    <th class="col-precio">P.Unit.</th>
                    <th class="col-total">Total</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($venta->productos as $detalle)
                    <tr>
                        <td class="col-cantidad">
                            {{ $detalle->pivot->cantidad }}
                            {{ $detalle->presentacione?->sigla ?? '' }}
                        </td>

                        <td class="col-producto">
                            {{ $detalle->nombre }}
                        </td>

                        <td class="col-precio">
                            {{ $simboloMoneda }}
                            {{ number_format((float) $detalle->pivot->precio_venta, 2) }}
                        </td>

                        <td class="col-total">
                            {{ $simboloMoneda }}
                            {{ number_format(
                                (float) $detalle->pivot->cantidad *
                                (float) $detalle->pivot->precio_venta,
                                2
                            ) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">
                            No hay productos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- TOTALES --}}
        <div class="totales">

            <div class="total-fila">
                <span class="nombre">Subtotal:</span>

                <span class="valor">
                    {{ $simboloMoneda }}
                    {{ number_format((float) $venta->subtotal, 2) }}
                </span>
            </div>

            <div class="total-fila">
                <span class="nombre">Impuesto:</span>

                <span class="valor">
                    {{ $simboloMoneda }}
                    {{ number_format((float) $venta->impuesto, 2) }}
                </span>
            </div>

            <div class="total-final">
                <span>TOTAL:</span>

                <span>
                    {{ $simboloMoneda }}
                    {{ number_format((float) $venta->total, 2) }}
                </span>
            </div>

        </div>

        {{-- FORMA DE PAGO --}}
        <div class="pago">
            <strong>Forma de pago:</strong>
            {{ $venta->metodo_pago ?? 'No registrada' }}
        </div>

        {{-- ATENDIDO POR --}}
        <div class="pago">
            <strong>Atendido por:</strong>
            {{ $venta->user?->empleado?->razon_social
                ?: ($venta->user?->name ?? 'No registrado') }}
        </div>

        {{-- PIE --}}
        <div class="pie">
            <p class="gracias">¡Gracias por su compra!</p>
            <p>Conserve este comprobante.</p>
        </div>

    </div>

</body>
</html>
