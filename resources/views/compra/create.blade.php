@extends('layouts.app')

@section('title', 'Realizar compra')

@push('css')

<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    #tabla_detalle th,
    #tabla_detalle td {
        vertical-align: middle;
    }

    .precio-input {
        min-width: 120px;
    }

    .resumen-compra {
        max-width: 450px;
        margin-left: auto;
    }

    .resumen-compra tr:last-child {
        font-size: 1.15rem;
        font-weight: bold;
    }

    .text-total {
        font-size: 1.25rem;
        font-weight: bold;
    }
</style>

@endpush

@section('content')

<div class="container-fluid px-4">

    <h1 class="mt-4 text-center">Crear Compra</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('panel') }}">Inicio</a>
        </li>

        <li class="breadcrumb-item">
            <a href="{{ route('compras.index') }}">Compras</a>
        </li>

        <li class="breadcrumb-item active">
            Crear Compra
        </li>
    </ol>

</div>


<form action="{{ route('compras.store') }}"
      method="post"
      enctype="multipart/form-data">

    @csrf

    <div class="container-lg mt-4">

        <div class="row gy-4">

            {{-- ==========================================================
                 DATOS GENERALES
            =========================================================== --}}

            <div class="col-12">

                <div class="text-white bg-success p-2 text-center">
                    <strong>Datos generales de la compra</strong>
                </div>

                <div class="p-3 border border-3 border-success">

                    <div class="row g-4">

                        {{-- PROVEEDOR --}}
                        <div class="col-12">

                            <label for="proveedore_id" class="form-label">
                                Proveedor:
                            </label>

                            <select name="proveedore_id"
                                    id="proveedore_id"
                                    required
                                    class="form-control selectpicker show-tick"
                                    data-live-search="true"
                                    title="Selecciona un proveedor"
                                    data-size="5">

                                @foreach ($proveedores as $item)

                                    <option value="{{ $item->id }}">
                                        {{ $item->nombre_documento }}
                                    </option>

                                @endforeach

                            </select>

                            @error('proveedore_id')
                                <small class="text-danger">
                                    *{{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- COMPROBANTE --}}
                        <div class="col-md-4">

                            <label for="comprobante_id" class="form-label">
                                Comprobante:
                            </label>

                            <select name="comprobante_id"
                                    id="comprobante_id"
                                    required
                                    class="form-control selectpicker"
                                    title="Selecciona">

                                @foreach ($comprobantes as $item)

                                    <option value="{{ $item->id }}">
                                        {{ $item->nombre }}
                                    </option>

                                @endforeach

                            </select>

                            @error('comprobante_id')
                                <small class="text-danger">
                                    *{{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- NUMERO DE COMPROBANTE --}}
                        <div class="col-md-4">

                            <label for="numero_comprobante" class="form-label">
                                Número de comprobante:
                            </label>

                            <input type="text"
                                   name="numero_comprobante"
                                   id="numero_comprobante"
                                   class="form-control"
                                   placeholder="Ejemplo: F001-00001234">

                            @error('numero_comprobante')
                                <small class="text-danger">
                                    *{{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- ARCHIVO --}}
                        <div class="col-md-4">

                            <label for="file_comprobante" class="form-label">
                                Archivo del comprobante:
                            </label>

                            <input type="file"
                                   name="file_comprobante"
                                   id="file_comprobante"
                                   class="form-control"
                                   accept=".pdf">

                            @error('file_comprobante')
                                <small class="text-danger">
                                    *{{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- METODO DE PAGO --}}
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


                        {{-- FECHA --}}
                        <div class="col-md-6">

                            <label for="fecha_hora" class="form-label">
                                Fecha y hora:
                            </label>

                            <input required
                                   type="datetime-local"
                                   name="fecha_hora"
                                   id="fecha_hora"
                                   class="form-control"
                                   value="{{ old('fecha_hora') }}">

                            @error('fecha_hora')
                                <small class="text-danger">
                                    *{{ $message }}
                                </small>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- ==========================================================
                 DETALLE DE LA COMPRA
            =========================================================== --}}

            <div class="col-12">

                <div class="text-white bg-primary p-2 text-center">
                    <strong>Detalles de la compra</strong>
                </div>

                <div class="p-3 border border-3 border-primary">

                    <div class="row g-4">

                        {{-- PRODUCTO --}}
                        <div class="col-12">

                            <label for="producto_id" class="form-label">
                                Producto:
                            </label>

                            <select id="producto_id"
                                    class="form-control selectpicker"
                                    data-live-search="true"
                                    data-size="8"
                                    title="Busque un producto aquí">

                                @foreach ($productos as $item)

                                    <option value="{{ $item->id }}">
                                        {{ $item->nombre_completo }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- CANTIDAD --}}
                        <div class="col-md-3">

                            <label for="cantidad" class="form-label">
                                Cantidad:
                            </label>

                            <input type="number"
                                   id="cantidad"
                                   class="form-control"
                                   min="1"
                                   step="1"
                                   placeholder="Ejemplo: 10">

                        </div>


                        {{-- PRECIO DE COMPRA --}}
                        <div class="col-md-3">

                            <label for="precio_compra" class="form-label">
                                Precio de compra:
                            </label>

                            <input type="number"
                                   id="precio_compra"
                                   class="form-control"
                                   min="0.01"
                                   step="0.01"
                                   placeholder="Con IGV">

                            <small class="text-muted">
                                Precio unitario incluido IGV
                            </small>

                        </div>


                        {{-- PRECIO DE VENTA --}}
                        <div class="col-md-3">

                            <label for="precio_venta" class="form-label">
                                Precio de venta:
                            </label>

                            <input type="number"
                                   id="precio_venta"
                                   class="form-control"
                                   min="0.01"
                                   step="0.01"
                                   placeholder="Precio de venta">

                        </div>


                        {{-- VENCIMIENTO --}}
                        <div class="col-md-3">

                            <label for="fecha_vencimiento" class="form-label">
                                Fecha de vencimiento:
                            </label>

                            <input type="date"
                                   id="fecha_vencimiento"
                                   class="form-control">

                        </div>


                        {{-- BOTON AGREGAR --}}
                        <div class="col-12 text-end">

                            <button id="btn_agregar"
                                    class="btn btn-primary"
                                    type="button">

                                <i class="fa-solid fa-plus me-1"></i>
                                Agregar producto

                            </button>

                        </div>


                        {{-- ==================================================
                             TABLA
                        =================================================== --}}

                        <div class="col-12">

                            <div class="table-responsive">

                                <table id="tabla_detalle"
                                       class="table table-hover table-bordered">

                                    <thead class="bg-primary">

                                        <tr>

                                            <th class="text-white">
                                                Producto
                                            </th>

                                            <th class="text-white">
                                                Presentación
                                            </th>

                                            <th class="text-white text-center">
                                                Cantidad
                                            </th>

                                            <th class="text-white text-end">
                                                Precio compra
                                            </th>

                                            <th class="text-white text-end">
                                                Precio venta
                                            </th>

                                            <th class="text-white">
                                                Vencimiento
                                            </th>

                                            <th class="text-white text-end">
                                                Subtotal
                                            </th>

                                            <th class="text-white text-end">
                                                IGV
                                            </th>

                                            <th class="text-white text-end">
                                                Total
                                            </th>

                                            <th></th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                    </tbody>


                                    {{-- ==================================================
                                         RESUMEN
                                    =================================================== --}}

                                    <tfoot>

                                        <tr>

                                            <th colspan="8"
                                                class="text-end">

                                                Subtotal sin IGV:

                                            </th>

                                            <th class="text-end">

                                                <input type="hidden"
                                                       name="subtotal"
                                                       value="0"
                                                       id="inputSubtotal">

                                                <span id="sumas">
                                                    0.00
                                                </span>

                                                <span>
                                                    {{ $empresa->moneda->simbolo }}
                                                </span>

                                            </th>

                                            <th></th>

                                        </tr>


                                        <tr>

                                            <th colspan="8"
                                                class="text-end">

                                                IGV (18%):

                                            </th>

                                            <th class="text-end">

                                                <input type="hidden"
                                                       name="impuesto"
                                                       value="0"
                                                       id="inputImpuesto">

                                                <span id="igv">
                                                    0.00
                                                </span>

                                                <span>
                                                    {{ $empresa->moneda->simbolo }}
                                                </span>

                                            </th>

                                            <th></th>

                                        </tr>


                                        <tr class="table-success">

                                            <th colspan="8"
                                                class="text-end">

                                                TOTAL:

                                            </th>

                                            <th class="text-end text-total">

                                                <input type="hidden"
                                                       name="total"
                                                       value="0"
                                                       id="inputTotal">

                                                <span id="total">
                                                    0.00
                                                </span>

                                                <span>
                                                    {{ $empresa->moneda->simbolo }}
                                                </span>

                                            </th>

                                            <th></th>

                                        </tr>

                                    </tfoot>

                                </table>

                            </div>

                        </div>


                        {{-- CANCELAR --}}
                        <div class="col-12 mt-2">

                            <button id="cancelar"
                                    type="button"
                                    class="btn btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">

                                <i class="fa-solid fa-xmark me-1"></i>
                                Cancelar compra

                            </button>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ==========================================================
                 GUARDAR
            =========================================================== --}}

            <div class="col-12 mt-4 text-center">

                <button type="submit"
                        class="btn btn-success btn-lg"
                        id="guardar">

                    <i class="fa-solid fa-cart-shopping me-1"></i>
                    Realizar compra

                </button>

            </div>

        </div>

    </div>


    {{-- ==============================================================
         MODAL CANCELAR
    =============================================================== --}}

    <div class="modal fade"
         id="exampleModal"
         tabindex="-1"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h1 class="modal-title fs-5"
                        id="exampleModalLabel">

                        Advertencia

                    </h1>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>

                </div>


                <div class="modal-body">

                    ¿Seguro que quieres cancelar la compra?

                </div>


                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        Cerrar

                    </button>

                    <button id="btnCancelarCompra"
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

<script>

$(document).ready(function () {

    $('#btn_agregar').click(function () {
        agregarProducto();
    });

    $('#btnCancelarCompra').click(function () {
        cancelarCompra();
    });

    disableButtons();

});


/*
|--------------------------------------------------------------------------
| VARIABLES
|--------------------------------------------------------------------------
*/

let cont = 0;

let subtotal = [];

let sumas = 0;

let igv = 0;

let total = 0;

let arrayIdProductos = [];


/*
|--------------------------------------------------------------------------
| IGV
|--------------------------------------------------------------------------
|
| El precio de compra ingresado YA INCLUYE IGV.
|
| Ejemplo:
|
| Precio compra = S/ 5.00
| Cantidad = 20
| Total = S/ 100.00
|
| Subtotal sin IGV = 100 / 1.18 = 84.75
| IGV = 100 - 84.75 = 15.25
|
|--------------------------------------------------------------------------
*/

const impuesto = 18;


/*
|--------------------------------------------------------------------------
| CANCELAR COMPRA
|--------------------------------------------------------------------------
*/

function cancelarCompra() {

    $('#tabla_detalle tbody').empty();

    cont = 0;

    subtotal = [];

    sumas = 0;

    igv = 0;

    total = 0;

    arrayIdProductos = [];

    actualizarTotales();

    limpiarCampos();

    disableButtons();

}


/*
|--------------------------------------------------------------------------
| MOSTRAR / OCULTAR BOTONES
|--------------------------------------------------------------------------
*/

function disableButtons() {

    if (total <= 0) {

        $('#guardar').hide();

        $('#cancelar').hide();

    } else {

        $('#guardar').show();

        $('#cancelar').show();

    }

}


/*
|--------------------------------------------------------------------------
| AGREGAR PRODUCTO
|--------------------------------------------------------------------------
*/

function agregarProducto() {

    let idProducto = $('#producto_id').val();

    let textProducto = $('#producto_id option:selected').text().trim();

    let cantidad = parseInt($('#cantidad').val());

    let precioCompra = parseFloat($('#precio_compra').val());

    let precioVenta = parseFloat($('#precio_venta').val());

    let fechaVencimiento = $('#fecha_vencimiento').val();


    /*
    |--------------------------------------------------------------------------
    | VALIDAR PRODUCTO
    |--------------------------------------------------------------------------
    */

    if (!idProducto || !textProducto) {

        showModal('Debe seleccionar un producto.');

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDAR CANTIDAD
    |--------------------------------------------------------------------------
    */

    if (!Number.isInteger(cantidad) || cantidad <= 0) {

        showModal('La cantidad debe ser un número entero mayor que 0.');

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDAR PRECIO DE COMPRA
    |--------------------------------------------------------------------------
    */

    if (isNaN(precioCompra) || precioCompra <= 0) {

        showModal('Ingrese un precio de compra válido.');

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDAR PRECIO DE VENTA
    |--------------------------------------------------------------------------
    */

    if (isNaN(precioVenta) || precioVenta <= 0) {

        showModal('Ingrese un precio de venta válido.');

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | NO REPETIR PRODUCTO
    |--------------------------------------------------------------------------
    */

    if (arrayIdProductos.includes(idProducto)) {

        showModal('Este producto ya fue agregado a la compra.');

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | OBTENER NOMBRE Y PRESENTACIÓN
    |--------------------------------------------------------------------------
    */

    let nameProducto = textProducto;

    let presentacionProducto = '';

    let matchNombre = textProducto.match(/-\s(.*?)\s-/);

    let matchPresentacion = textProducto.match(/Presentación:\s(.*)/);


    if (matchNombre) {

        nameProducto = matchNombre[1];

    }


    if (matchPresentacion) {

        presentacionProducto = matchPresentacion[1];

    }


    /*
    |--------------------------------------------------------------------------
    | CALCULAR TOTAL DEL PRODUCTO
    |--------------------------------------------------------------------------
    |
    | El precio de compra YA incluye IGV.
    |
    | Cantidad × precio compra = total del producto
    |
    */

    let totalProducto = round(cantidad * precioCompra);


    /*
    |--------------------------------------------------------------------------
    | CALCULAR SUBTOTAL SIN IGV
    |--------------------------------------------------------------------------
    |
    | Si el total ya contiene IGV:
    |
    | subtotal = total / 1.18
    |
    */

    let subtotalProducto = round(
        totalProducto / (1 + impuesto / 100)
    );


    /*
    |--------------------------------------------------------------------------
    | CALCULAR IGV DEL PRODUCTO
    |--------------------------------------------------------------------------
    */

    let igvProducto = round(
        totalProducto - subtotalProducto
    );


    /*
    |--------------------------------------------------------------------------
    | ACUMULAR TOTALES
    |--------------------------------------------------------------------------
    */

    subtotal[cont] = subtotalProducto;

    sumas = round(
        sumas + subtotalProducto
    );

    igv = round(
        igv + igvProducto
    );

    total = round(
        total + totalProducto
    );


    /*
    |--------------------------------------------------------------------------
    | CREAR FILA
    |--------------------------------------------------------------------------
    */

    let fila = `
        <tr id="fila${cont}">

            <td>

                <input type="hidden"
                       name="arrayidproducto[]"
                       value="${idProducto}">

                ${nameProducto}

            </td>


            <td>
                ${presentacionProducto}
            </td>


            <td class="text-center">

                <input type="hidden"
                       name="arraycantidad[]"
                       value="${cantidad}">

                ${cantidad}

            </td>


            <td class="text-end">

                <input type="hidden"
                       name="arraypreciocompra[]"
                       value="${precioCompra.toFixed(2)}">

                ${precioCompra.toFixed(2)}

            </td>


            <td class="text-end">

                <input type="hidden"
                       name="arrayprecioventa[]"
                       value="${precioVenta.toFixed(2)}">

                ${precioVenta.toFixed(2)}

            </td>


            <td>

                <input type="hidden"
                       name="arrayfechavencimiento[]"
                       value="${fechaVencimiento}">

                ${fechaVencimiento || '—'}

            </td>


            <td class="text-end">

                ${subtotalProducto.toFixed(2)}

            </td>


            <td class="text-end">

                ${igvProducto.toFixed(2)}

            </td>


            <td class="text-end fw-semibold">

                ${totalProducto.toFixed(2)}

            </td>


            <td class="text-center">

                <button class="btn btn-danger"
                        type="button"
                        onclick="eliminarProducto(${cont}, '${idProducto}')">

                    <i class="fa-solid fa-trash"></i>

                </button>

            </td>

        </tr>
    `;


    $('#tabla_detalle tbody').append(fila);


    /*
    |--------------------------------------------------------------------------
    | GUARDAR ID
    |--------------------------------------------------------------------------
    */

    arrayIdProductos.push(idProducto);


    cont++;


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR
    |--------------------------------------------------------------------------
    */

    actualizarTotales();

    limpiarCampos();

    disableButtons();

}


/*
|--------------------------------------------------------------------------
| ELIMINAR PRODUCTO
|--------------------------------------------------------------------------
*/

function eliminarProducto(indice, idProducto) {

    /*
    |--------------------------------------------------------------------------
    | RECUPERAR EL TOTAL DE LA FILA
    |--------------------------------------------------------------------------
    */

    let fila = $('#fila' + indice);


    let cantidad = parseFloat(
        fila.find('input[name="arraycantidad[]"]').val()
    );


    let precioCompra = parseFloat(
        fila.find('input[name="arraypreciocompra[]"]').val()
    );


    let totalProducto = round(
        cantidad * precioCompra
    );


    let subtotalProducto = round(
        totalProducto / (1 + impuesto / 100)
    );


    let igvProducto = round(
        totalProducto - subtotalProducto
    );


    /*
    |--------------------------------------------------------------------------
    | RESTAR
    |--------------------------------------------------------------------------
    */

    sumas = round(
        sumas - subtotalProducto
    );

    igv = round(
        igv - igvProducto
    );

    total = round(
        total - totalProducto
    );


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR FILA
    |--------------------------------------------------------------------------
    */

    fila.remove();


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR ID
    |--------------------------------------------------------------------------
    */

    let index = arrayIdProductos.indexOf(
        idProducto.toString()
    );


    if (index !== -1) {

        arrayIdProductos.splice(index, 1);

    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR
    |--------------------------------------------------------------------------
    */

    actualizarTotales();

    disableButtons();

}


/*
|--------------------------------------------------------------------------
| ACTUALIZAR TOTALES
|--------------------------------------------------------------------------
*/

function actualizarTotales() {

    $('#sumas').html(
        sumas.toFixed(2)
    );

    $('#igv').html(
        igv.toFixed(2)
    );

    $('#total').html(
        total.toFixed(2)
    );


    $('#inputSubtotal').val(
        sumas.toFixed(2)
    );

    $('#inputImpuesto').val(
        igv.toFixed(2)
    );

    $('#inputTotal').val(
        total.toFixed(2)
    );

}


/*
|--------------------------------------------------------------------------
| LIMPIAR CAMPOS
|--------------------------------------------------------------------------
*/

function limpiarCampos() {

    $('#producto_id').selectpicker('val', '');

    $('#cantidad').val('');

    $('#precio_compra').val('');

    $('#precio_venta').val('');

    $('#fecha_vencimiento').val('');

}


/*
|--------------------------------------------------------------------------
| REDONDEAR
|--------------------------------------------------------------------------
*/

function round(num, decimales = 2) {

    return Number(
        Math.round(
            num + 'e' + decimales
        ) + 'e-' + decimales
    );

}


/*
|--------------------------------------------------------------------------
| MENSAJES
|--------------------------------------------------------------------------
*/

function showModal(message, icon = 'error') {

    const Toast = Swal.mixin({

        toast: true,

        position: 'top-end',

        showConfirmButton: false,

        timer: 3000,

        timerProgressBar: true,

        didOpen: (toast) => {

            toast.addEventListener(
                'mouseenter',
                Swal.stopTimer
            );

            toast.addEventListener(
                'mouseleave',
                Swal.resumeTimer
            );

        }

    });


    Toast.fire({

        icon: icon,

        title: message

    });

}

</script>

@endpush