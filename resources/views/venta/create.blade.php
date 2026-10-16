@extends('layouts.app')

@section('title', 'Realizar venta')

@push('css')
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

<div class="container-fluid px-4">

    <h1 class="mt-4 text-center">
        Realizar Venta
    </h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('panel') }}">Inicio</a>
        </li>

        <li class="breadcrumb-item">
            <a href="{{ route('ventas.index') }}">Ventas</a>
        </li>

        <li class="breadcrumb-item active">
            Realizar Venta
        </li>
    </ol>

</div>

<form action="{{ route('ventas.store') }}" method="post">

    @csrf

    <div class="container-lg mt-4">

        <div class="row gy-4">

            {{-- ==========================================================
                DATOS GENERALES
            ========================================================== --}}
            <div class="col-12">

                <div class="text-white bg-success p-1 text-center">
                    Datos generales
                </div>

                <div class="p-3 border border-3 border-success">

                    <div class="row g-4">

                        {{-- Comprobante --}}
                        <div class="col-md-6">
                            <label for="comprobante_id" class="form-label text-primary fw-bold">
                                Comprobante:
                                <i class="bi bi-arrow-down"></i>
                            </label>

                            <select name="comprobante_id"
                                    id="comprobante_id"
                                    class="form-control selectpicker"
                                    title="Selecciona"
                                    data-style="btn-outline-primary"
                                    required>

                                @foreach ($comprobantes as $item)
                                    <option value="{{ $item->id }}"
                                            data-nombre="{{ strtolower($item->nombre) }}">
                                        {{ $item->nombre }}
                                    </option>
                                @endforeach

                            </select>

                            @error('comprobante_id')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Datos del cliente - Boleta --}}
                        <div class="col-12" id="datos-boleta" style="display: none;">

                            <div class="card mt-3">

                                <div class="card-header">
                                    <strong>Datos del cliente - Boleta</strong>
                                </div>

                                <div class="card-body">

                                    <div class="row g-3">

                                        {{-- DNI --}}
                                        <div class="col-md-4">
                                            <label for="dni_simple" class="form-label">
                                                DNI:
                                            </label>

                                            <div class="input-group">
                                                <input type="text"
                                                    name="dni_simple"
                                                    id="dni_simple"
                                                    class="form-control"
                                                    placeholder="Ingresa 8 dígitos"
                                                    maxlength="8"
                                                    inputmode="numeric"
                                                    pattern="[0-9]{8}"
                                                    autocomplete="off">

                                                <button type="button"
                                                        id="btn-buscar-dni"
                                                        class="btn btn-primary">
                                                    Buscar
                                                </button>
                                            </div>

                                            <small id="dni-mensaje" class="text-muted">
                                                Ingresa un DNI de 8 dígitos.
                                            </small>
                                        </div>

                                        {{-- Nombre --}}
                                        <div class="col-md-4">
                                            <label for="nombre_simple" class="form-label">
                                                Nombre:
                                            </label>

                                            <input type="text"
                                                name="nombre_simple"
                                                id="nombre_simple"
                                                class="form-control"
                                                placeholder="Nombre del cliente">
                                        </div>

                                        {{-- Apellido --}}
                                        <div class="col-md-4">
                                            <label for="apellidos_simple" class="form-label">
                                                Apellido:
                                            </label>

                                            <input type="text"
                                                name="apellidos_simple"
                                                id="apellidos_simple"
                                                class="form-control"
                                                placeholder="Apellido del cliente">
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Datos del cliente - Nota de venta --}}
                        <div class="col-12" id="datos-nota-venta" style="display: none;">

                            <div class="card mt-3">

                                <div class="card-header">
                                    <strong>Datos del cliente - Nota de venta</strong>
                                </div>

                                <div class="card-body">

                                    <div class="row g-3">

                                        {{-- DNI --}}
                                        <div class="col-md-4">
                                            <label for="dni_nota" class="form-label">
                                                DNI:
                                            </label>

                                            <div class="input-group">
                                                <input type="text"
                                                    name="dni_nota"
                                                    id="dni_nota"
                                                    class="form-control"
                                                    placeholder="Ingresa 8 dígitos"
                                                    maxlength="8"
                                                    inputmode="numeric"
                                                    pattern="[0-9]{8}"
                                                    autocomplete="off">

                                                <button type="button"
                                                        id="btn-buscar-dni-nota"
                                                        class="btn btn-primary">
                                                    Buscar
                                                </button>
                                            </div>

                                            <small id="dni-mensaje-nota" class="text-muted">
                                                Ingresa un DNI de 8 dígitos.
                                            </small>
                                        </div>

                                        {{-- Nombre --}}
                                        <div class="col-md-4">
                                            <label for="nombre_nota" class="form-label">
                                                Nombre:
                                            </label>

                                            <input type="text"
                                                name="nombre_nota"
                                                id="nombre_nota"
                                                class="form-control"
                                                placeholder="Nombre del cliente">
                                        </div>

                                        {{-- Apellido --}}
                                        <div class="col-md-4">
                                            <label for="apellidos_nota" class="form-label">
                                                Apellido:
                                            </label>

                                            <input type="text"
                                                name="apellidos_nota"
                                                id="apellidos_nota"
                                                class="form-control"
                                                placeholder="Apellido del cliente">
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        {{-- Datos del cliente - Factura --}}
                        <div class="col-12" id="datos-factura" style="display: none;">

                            <div class="card mt-3">

                                <div class="card-header">
                                    <strong>Datos del cliente - Factura</strong>
                                </div>

                                <div class="card-body">

                                    <div class="row g-3">

                                        {{-- RUC --}}
                                        <div class="col-md-4">
                                            <label for="ruc_factura" class="form-label">
                                                RUC:
                                            </label>

                                            <div class="input-group">
                                                <input type="text"
                                                    name="ruc_factura"
                                                    id="ruc_factura"
                                                    class="form-control"
                                                    placeholder="Ingresa 11 dígitos"
                                                    maxlength="11"
                                                    inputmode="numeric"
                                                    pattern="[0-9]{11}"
                                                    autocomplete="off">

                                                <button type="button"
                                                        id="btn-buscar-ruc"
                                                        class="btn btn-primary">
                                                    Buscar
                                                </button>
                                            </div>

                                            <small id="ruc-mensaje" class="text-muted">
                                                Ingresa un RUC de 11 dígitos.
                                            </small>
                                        </div>

                                        {{-- Razón social --}}
                                        <div class="col-md-4">
                                            <label for="razon_social_factura" class="form-label">
                                                Razón social:
                                            </label>

                                            <input type="text"
                                                name="razon_social_factura"
                                                id="razon_social_factura"
                                                class="form-control"
                                                placeholder="Razón social del cliente">
                                        </div>

                                        {{-- Dirección --}}
                                        <div class="col-md-4">
                                            <label for="direccion_factura" class="form-label">
                                                Dirección:
                                            </label>

                                            <input type="text"
                                                name="direccion_factura"
                                                id="direccion_factura"
                                                class="form-control"
                                                placeholder="Dirección fiscal del cliente">
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Método de pago --}}
                        <div class="col-md-6">

                            <label for="metodo_pago" class="form-label">
                                Método de pago:
                            </label>

                            <select required
                                    name="metodo_pago"
                                    id="metodo_pago"
                                    class="form-control selectpicker"
                                    title="Selecciona">

                                @foreach ($optionsMetodoPago as $item)
                                    <option value="{{ $item->value }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('metodo_pago')
                                <small class="text-danger">
                                    *{{ $message }}
                                </small>
                            @enderror

                        </div>

                        {{-- Cliente --}}
                        <div class="col-12">

                            <label for="cliente_id" class="form-label">
                                Cliente:
                            </label>

                            <select name="cliente_id"
                                    id="cliente_id"
                                    class="form-control selectpicker show-tick"
                                    data-live-search="true"
                                    title="Selecciona"
                                    data-size="2">

                                @foreach ($clientes as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nombre_documento }}
                                    </option>
                                @endforeach

                            </select>

                            @error('cliente_id')
                                <small class="text-danger">
                                    *{{ $message }}
                                </small>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>
            {{-- ==========================================================
                DETALLE DE VENTA
            ========================================================== --}}

            <div class="col-12">

                <div class="text-white bg-primary p-1 text-center">
                    Detalles de la venta
                </div>

                <div class="p-3 border border-3 border-primary">

                    <div class="row gy-4">

                        {{-- ESCÁNER --}}
                        <div class="col-12">

                            <label for="codigo_barras" class="form-label">
                                Escanear código de barras:
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="fa-solid fa-barcode"></i>
                                </span>

                                <input type="text"
                                    id="codigo_barras"
                                    class="form-control"
                                    placeholder="Escanee el código de barras aquí"
                                    autocomplete="off"
                                    autofocus>

                                <button type="button"
                                    id="btnEscanear"
                                    class="btn btn-dark">

                                    <i class="fa-solid fa-barcode"></i>
                                    Escanear

                                </button>

                            </div>

                            <small class="text-muted">
                                Escanee el código con su lector de código de barras.
                            </small>

                        </div>

                        {{-- PRODUCTO --}}
                        <div class="col-12">

                            <label for="producto_id" class="form-label">
                                Producto:
                            </label>

                            <select id="producto_id"
                                class="form-control selectpicker"
                                data-live-search="true"
                                data-size="1"
                                title="Busque un producto aquí">

                                @foreach ($productos as $item)
                                    <option
                                        value="{{ $item->id }}-{{ $item->cantidad }}-{{ $item->precio }}-{{ $item->nombre }}-{{ $item->sigla }}"
                                        data-codigo="{{ $item->codigo }}"
                                        data-id="{{ $item->id }}"
                                        data-stock="{{ $item->cantidad }}"
                                        data-precio="{{ $item->precio }}"
                                        data-nombre="{{ $item->nombre }}"
                                        data-sigla="{{ $item->sigla }}">

                                        {{ 'Código: ' . $item->codigo . ' - ' . $item->nombre . ' - ' . $item->sigla }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- STOCK --}}
                        <div class="d-flex justify-content-end">

                            <div class="col-12 col-sm-6">

                                <div class="row">

                                    <label for="stock"
                                        class="col-form-label col-4">
                                        En stock:
                                    </label>

                                    <div class="col-8">
                                        <input disabled
                                            id="stock"
                                            type="text"
                                            class="form-control">
                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- PRECIO DE VENTA --}}
                        <div class="d-flex justify-content-end">

                            <div class="col-12 col-sm-6">

                                <div class="row">

                                    <label for="precio"
                                        class="col-form-label col-4">
                                        Precio:
                                    </label>

                                    <div class="col-8">
                                        <input disabled
                                            id="precio"
                                            type="number"
                                            class="form-control"
                                            step="any">
                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- CANTIDAD --}}
                        <div class="col-md-6">

                            <label for="cantidad" class="form-label">
                                Cantidad:
                            </label>

                            <input type="number"
                                id="cantidad"
                                class="form-control"
                                min="1"
                                step="1">

                        </div>

                        {{-- BOTÓN AGREGAR --}}
                        <div class="col-12 text-end">

                            <button id="btn_agregar"
                                class="btn btn-primary"
                                type="button">

                                <i class="fa-solid fa-plus"></i>
                                Agregar

                            </button>

                        </div>

                        {{-- TABLA --}}
                        <div class="col-12">

                            <div class="table-responsive">

                                <table id="tabla_detalle"
                                    class="table table-hover align-middle">

                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-white">Producto</th>
                                            <th class="text-white">Presentación</th>
                                            <th class="text-white">Cantidad</th>
                                            <th class="text-white">Precio venta</th>
                                            <th class="text-white">Base</th>
                                            <th class="text-white">IGV</th>
                                            <th class="text-white">Total</th>
                                            <th class="text-white">Acción</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr id="filaVacia">
                                            <td colspan="8"
                                                class="text-center text-muted">
                                                No hay productos agregados.
                                            </td>
                                        </tr>
                                    </tbody>

                                    <tfoot>

                                        {{-- BASE --}}
                                        <tr>
                                            <th colspan="6" class="text-end">
                                                Base:
                                            </th>

                                            <th colspan="2">
                                                <input type="hidden"
                                                    name="subtotal"
                                                    value="0"
                                                    id="inputSubtotal">

                                                <span id="sumas">0.00</span>

                                                <span>
                                                    {{ $empresa->moneda->simbolo }}
                                                </span>
                                            </th>
                                        </tr>

                                        {{-- IGV --}}
                                        <tr>
                                            <th colspan="6" class="text-end">
                                                {{ $empresa->abreviatura_impuesto }}
                                                ({{ $empresa->porcentaje_impuesto }}%):
                                            </th>

                                            <th colspan="2">
                                                <input type="hidden"
                                                    name="impuesto"
                                                    id="inputImpuesto"
                                                    value="0">

                                                <span id="igv">0.00</span>

                                                <span>
                                                    {{ $empresa->moneda->simbolo }}
                                                </span>
                                            </th>
                                        </tr>

                                        {{-- TOTAL --}}
                                        <tr>
                                            <th colspan="6" class="text-end">
                                                Total:
                                            </th>

                                            <th colspan="2">
                                                <input type="hidden"
                                                    name="total"
                                                    value="0"
                                                    id="inputTotal">

                                                <span id="total">0.00</span>

                                                <span>
                                                    {{ $empresa->moneda->simbolo }}
                                                </span>
                                            </th>
                                        </tr>

                                    </tfoot>

                                </table>

                            </div>

                        </div>

                        {{-- CANCELAR --}}
                        <div class="col-12">

                            <button id="cancelar"
                                type="button"
                                class="btn btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModal">

                                <i class="fa-solid fa-xmark"></i>
                                Cancelar venta

                            </button>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ==========================================================
                FINALIZAR VENTA
            ========================================================== --}}

            <div class="col-12">

                <div class="text-white bg-primary p-1 text-center">
                    Finalizar venta
                </div>

                <div class="p-3 border border-3 border-primary">

                    <div class="row gy-4">

                        {{-- DINERO RECIBIDO --}}
                        <div class="col-md-6">

                            <label for="dinero_recibido" class="form-label">
                                Ingrese dinero recibido:
                            </label>

                            <input type="number"
                                id="dinero_recibido"
                                name="monto_recibido"
                                class="form-control"
                                step="any">

                        </div>

                        {{-- VUELTO --}}
                        <div class="col-md-6">

                            <label for="vuelto" class="form-label">
                                Vuelto:
                            </label>

                            <input readonly
                                type="number"
                                name="vuelto_entregado"
                                id="vuelto"
                                class="form-control"
                                step="any">

                        </div>

                        {{-- GUARDAR --}}
                        <div class="col-12 text-center">

                            <button type="submit"
                                class="btn btn-success"
                                id="guardar">

                                <i class="fa-solid fa-check"></i>
                                Realizar venta

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- ==========================================================
        MODAL CANCELAR
    ========================================================== --}}

    <div class="modal fade"
        id="exampleModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Advertencia
                    </h1>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>

                </div>

                <div class="modal-body">
                    ¿Seguro que quieres cancelar la venta?
                </div>

                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cerrar
                    </button>

                    <button id="btnCancelarVenta"
                        type="button"
                        class="btn btn-danger"
                        data-bs-dismiss="modal">
                        Confirmar
                    </button>

                </div>

            </div>

        </div>

    </div>

</form>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

@vite('resources/js/venta/create.js')
@endpush