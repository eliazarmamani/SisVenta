
/*
|--------------------------------------------------------------------------
| COMPROBANTE, DATOS DEL CLIENTE Y CONSULTA DNI / RUC
|--------------------------------------------------------------------------
*/

$(document).ready(function () {
    const comprobante = document.getElementById('comprobante_id');

    const datosBoleta = document.getElementById('datos-boleta');
    const datosNotaVenta = document.getElementById('datos-nota-venta');
    const datosFactura = document.getElementById('datos-factura');

    const dni = document.getElementById('dni_simple');
    const botonBuscar = document.getElementById('btn-buscar-dni');
    const mensaje = document.getElementById('dni-mensaje');

    const dniNota = document.getElementById('dni_nota');
    const botonDniNota = document.getElementById('btn-buscar-dni-nota');
    const mensajeDniNota = document.getElementById('dni-mensaje-nota');

    const ruc = document.getElementById('ruc_factura');
    const botonBuscarRuc = document.getElementById('btn-buscar-ruc');
    const mensajeRuc = document.getElementById('ruc-mensaje');
    const razonSocial = document.getElementById('razon_social_factura');
    const direccion = document.getElementById('direccion_factura');

    /*
    |--------------------------------------------------------------------------
    | MOSTRAR CAMPOS SEGÚN EL COMPROBANTE
    |--------------------------------------------------------------------------
    */

    function actualizarComprobante() {
        if (!comprobante) return;

        const opcion = comprobante.options[comprobante.selectedIndex];

        const nombreComprobante = (
            opcion?.dataset.nombre || ''
        ).trim().toLowerCase();

        const mostrarBoleta = nombreComprobante === 'boleta';

        const mostrarNotaVenta =
            nombreComprobante.includes('nota') &&
            nombreComprobante.includes('venta');

        const mostrarFactura = nombreComprobante === 'factura';

        if (datosBoleta) {
            datosBoleta.style.display = mostrarBoleta ? 'block' : 'none';

            datosBoleta.querySelectorAll('input').forEach(function (input) {
                input.disabled = !mostrarBoleta;
            });
        }

        if (datosNotaVenta) {
            datosNotaVenta.style.display = mostrarNotaVenta ? 'block' : 'none';

            datosNotaVenta.querySelectorAll('input').forEach(function (input) {
                input.disabled = !mostrarNotaVenta;
            });
        }

        if (datosFactura) {
            datosFactura.style.display = mostrarFactura ? 'block' : 'none';

            datosFactura.querySelectorAll('input').forEach(function (input) {
                input.disabled = !mostrarFactura;
            });
        }

        if (!mostrarBoleta) {
            const nombre = document.getElementById('nombre_simple');
            const apellidos = document.getElementById('apellidos_simple');

            if (dni) dni.value = '';
            if (nombre) nombre.value = '';
            if (apellidos) apellidos.value = '';

            if (mensaje) {
                mensaje.textContent = '';
                mensaje.className = 'text-muted';
            }
        }

        if (!mostrarNotaVenta) {
            const nombreNota = document.getElementById('nombre_nota');
            const apellidosNota = document.getElementById('apellidos_nota');

            if (dniNota) dniNota.value = '';
            if (nombreNota) nombreNota.value = '';
            if (apellidosNota) apellidosNota.value = '';

            if (mensajeDniNota) {
                mensajeDniNota.textContent = '';
                mensajeDniNota.className = 'text-muted';
            }
        }

        if (!mostrarFactura) {
            if (ruc) ruc.value = '';
            if (razonSocial) razonSocial.value = '';
            if (direccion) direccion.value = '';

            if (mensajeRuc) {
                mensajeRuc.textContent = 'Ingresa un RUC de 11 dígitos.';
                mensajeRuc.className = 'text-muted';
            }
        }
    }

    if (comprobante) {
        comprobante.addEventListener('change', actualizarComprobante);
        $(comprobante).on('changed.bs.select', actualizarComprobante);
        actualizarComprobante();
    }

    /*
    |--------------------------------------------------------------------------
    | CONSULTAR DNI
    |--------------------------------------------------------------------------
    */

    async function consultarDni(numeroDni) {
        const respuesta = await fetch(
            '/admin/ventas/consultar-dni?dni=' +
            encodeURIComponent(numeroDni),
            {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                signal: AbortSignal.timeout(12000)
            }
        );

        const datos = await respuesta.json();

        if (!respuesta.ok) {
            throw new Error(
                datos.error ||
                datos.message ||
                'No se pudo consultar el DNI.'
            );
        }

        if (
            !datos.nombre ||
            typeof datos.nombre !== 'string' ||
            !datos.nombre.trim()
        ) {
            throw new Error('La API no devolvió los nombres del cliente.');
        }

        return datos;
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIGURAR CONSULTA DNI
    |--------------------------------------------------------------------------
    */

    function configurarConsultaDni(
        campoDni,
        boton,
        mensajeDni,
        campoNombre,
        campoApellido
    ) {
        if (!campoDni || !boton || !mensajeDni) return;

        campoDni.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 8);

            mensajeDni.textContent = 'Ingresa un DNI de 8 dígitos.';
            mensajeDni.className = 'text-muted';
        });

        boton.addEventListener('click', async function () {
            const numeroDni = campoDni.value.trim();

            if (!/^\d{8}$/.test(numeroDni)) {
                mensajeDni.textContent = 'Ingresa un DNI válido de 8 dígitos.';
                mensajeDni.className = 'text-danger';
                campoDni.focus();
                return;
            }

            boton.disabled = true;

            const textoOriginal = boton.textContent;
            boton.textContent = 'Buscando...';

            mensajeDni.textContent = 'Consultando DNI...';
            mensajeDni.className = 'text-primary';

            const inicio = performance.now();

            try {
                const datos = await consultarDni(numeroDni);

                if (campoNombre) {
                    campoNombre.value = datos.nombre;
                    campoNombre.dispatchEvent(
                        new Event('change', { bubbles: true })
                    );
                }

                if (campoApellido) {
                    campoApellido.value = datos.apellido || '';
                    campoApellido.dispatchEvent(
                        new Event('change', { bubbles: true })
                    );
                }

                const segundos = (
                    (performance.now() - inicio) / 1000
                ).toFixed(2);

                mensajeDni.textContent =
                    'DNI consultado correctamente (' + segundos + ' s).';
                mensajeDni.className = 'text-success';

            } catch (error) {
                console.error('Error al consultar DNI:', error);

                mensajeDni.textContent =
                    error.name === 'TimeoutError' ||
                    error.name === 'AbortError'
                        ? 'La consulta tardó demasiado. Intenta nuevamente.'
                        : error.message ||
                          'Error de conexión al consultar el DNI.';

                mensajeDni.className = 'text-danger';

            } finally {
                boton.disabled = false;
                boton.textContent = textoOriginal;
            }
        });
    }

    configurarConsultaDni(
        dni,
        botonBuscar,
        mensaje,
        document.getElementById('nombre_simple'),
        document.getElementById('apellidos_simple')
    );

    configurarConsultaDni(
        dniNota,
        botonDniNota,
        mensajeDniNota,
        document.getElementById('nombre_nota'),
        document.getElementById('apellidos_nota')
    );

    /*
    |--------------------------------------------------------------------------
    | PREPARAR CAMPO RUC
    |--------------------------------------------------------------------------
    */

    if (ruc) {
        ruc.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 11);

            if (mensajeRuc) {
                mensajeRuc.textContent = 'Ingresa un RUC de 11 dígitos.';
                mensajeRuc.className = 'text-muted';
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | CONSULTAR RUC
    |--------------------------------------------------------------------------
    */

    if (botonBuscarRuc && ruc && mensajeRuc) {
        botonBuscarRuc.addEventListener('click', async function () {
            const numeroRuc = ruc.value.trim();

            if (!/^\d{11}$/.test(numeroRuc)) {
                mensajeRuc.textContent = 'Ingresa un RUC válido de 11 dígitos.';
                mensajeRuc.className = 'text-danger';
                ruc.focus();
                return;
            }

            const textoOriginal = botonBuscarRuc.textContent;

            botonBuscarRuc.disabled = true;
            botonBuscarRuc.textContent = 'Buscando...';

            mensajeRuc.textContent = 'Consultando RUC...';
            mensajeRuc.className = 'text-primary';

            try {
                const respuesta = await fetch(
                    '/admin/ventas/consultar-ruc?ruc=' +
                    encodeURIComponent(numeroRuc),
                    {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        },
                        signal: AbortSignal.timeout(12000)
                    }
                );

                const datos = await respuesta.json();

                if (!respuesta.ok) {
                    throw new Error(
                        datos.error ||
                        datos.message ||
                        'No se pudo consultar el RUC.'
                    );
                }

                if (!datos.razon_social) {
                    throw new Error('La API no devolvió la razón social.');
                }

                if (razonSocial) {
                    razonSocial.value = datos.razon_social;
                    razonSocial.dispatchEvent(
                        new Event('change', { bubbles: true })
                    );
                }

                if (direccion) {
                    direccion.value = datos.direccion || '';
                    direccion.dispatchEvent(
                        new Event('change', { bubbles: true })
                    );
                }

                mensajeRuc.textContent = 'RUC consultado correctamente.';
                mensajeRuc.className = 'text-success';

            } catch (error) {
                console.error('Error al consultar RUC:', error);

                mensajeRuc.textContent =
                    error.name === 'TimeoutError' ||
                    error.name === 'AbortError'
                        ? 'La consulta tardó demasiado. Intenta nuevamente.'
                        : error.message ||
                          'Error de conexión al consultar el RUC.';

                mensajeRuc.className = 'text-danger';

            } finally {
                botonBuscarRuc.disabled = false;
                botonBuscarRuc.textContent = textoOriginal;
            }
        });
    }
});


/*
|--------------------------------------------------------------------------
| VENTA: PRODUCTOS, ESCÁNER, TOTALES Y CANCELACIÓN
|--------------------------------------------------------------------------
*/

$(document).ready(function () {
    $('#producto_id').on('change', function () {
        mostrarValores();
    });

    $('#btn_agregar').on('click', function (e) {
        e.preventDefault();
        agregarProducto(false);
    });

    /*
    |--------------------------------------------------------------------------
    | RECORRIDO CON ENTER
    |--------------------------------------------------------------------------
    */

    // Desde el producto, pasar a la cantidad.
    $('#producto_id').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            e.stopPropagation();

            $('#cantidad').trigger('focus').select();
        }
    });

    // Desde la cantidad, agregar el producto.
    $('#cantidad').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            e.stopPropagation();

            agregarProducto(false);
        }
    });

    $('#btnEscanear').on('click', function () {
        $('#codigo_barras').trigger('focus');
    });

    $('#codigo_barras').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            e.stopPropagation();

            const codigo = $(this).val().trim();

            if (codigo !== '') {
                buscarProductoPorCodigo(codigo);
            }
        }
    });

    $('#btnCancelarVenta').on('click', function () {
        cancelarVenta();
    });

    $('#dinero_recibido').on('input', function () {
        const dineroRecibido = parseFloat($(this).val());

        if (
            !isNaN(dineroRecibido) &&
            dineroRecibido >= total &&
            total > 0
        ) {
            $('#vuelto').val((dineroRecibido - total).toFixed(2));
        } else {
            $('#vuelto').val('');
        }
    });

    disableButtons();
    $('#codigo_barras').trigger('focus');
});


/*
|--------------------------------------------------------------------------
| VARIABLES Y CONFIGURACIÓN
|--------------------------------------------------------------------------
*/

let cont = 0;
let subtotal = [];
let sumas = 0;
let igv = 0;
let total = 0;

const tablaDetalle = document.getElementById('tabla_detalle');

const impuesto = Number(
    tablaDetalle?.dataset.porcentajeImpuesto ??
    document.querySelector('meta[name="porcentaje-impuesto"]')?.content ??
    18
);


/*
|--------------------------------------------------------------------------
| OBTENER CANTIDAD AGREGADA DE UN PRODUCTO
|--------------------------------------------------------------------------
*/

function obtenerCantidadAgregada(idProducto) {
    let cantidadAgregada = 0;

    $('#tabla_detalle tbody tr[data-producto-id]').each(function () {
        if (
            String($(this).attr('data-producto-id')) ===
            String(idProducto)
        ) {
            cantidadAgregada += parseInt(
                $(this).find('.cantidad-producto').text(),
                10
            ) || 0;
        }
    });

    return cantidadAgregada;
}


/*
|--------------------------------------------------------------------------
| OBTENER STOCK RESTANTE EN LA VENTA ACTUAL
|--------------------------------------------------------------------------
*/

function obtenerStockRestante(option) {
    const idProducto = option.data('id');
    const stockOriginal = parseInt(option.attr('data-stock'), 10);

    if (!idProducto || isNaN(stockOriginal)) {
        return 0;
    }

    return Math.max(
        0,
        stockOriginal - obtenerCantidadAgregada(idProducto)
    );
}


/*
|--------------------------------------------------------------------------
| MOSTRAR VALORES DEL PRODUCTO SELECCIONADO
|--------------------------------------------------------------------------
*/

function mostrarValores() {
    const option = $('#producto_id option:selected');

    if (!option.val()) {
        $('#stock').val('');
        $('#precio').val('');
        return;
    }

    $('#stock').val(obtenerStockRestante(option));
    $('#precio').val(option.data('precio'));
}


/*
|--------------------------------------------------------------------------
| BUSCAR PRODUCTO POR CÓDIGO DE BARRAS
|--------------------------------------------------------------------------
*/

function buscarProductoPorCodigo(codigo) {
    codigo = codigo.toString().trim();

    if (codigo === '') return;

    let encontrado = false;

    $('#producto_id option').each(function () {
        const codigoProducto = $(this).attr('data-codigo');

        if (
            codigoProducto !== undefined &&
            codigoProducto.toString().trim() === codigo
        ) {
            encontrado = true;

            $('#producto_id').selectpicker('val', $(this).val());

            mostrarValores();
            $('#cantidad').val(1);

            agregarProducto(true);
            $('#codigo_barras').val('');

            setTimeout(function () {
                $('#codigo_barras').trigger('focus');
            }, 50);

            return false;
        }
    });

    if (!encontrado) {
        showModal('No se encontró ningún producto con el código: ' + codigo);
        $('#codigo_barras').val('');

        setTimeout(function () {
            $('#codigo_barras').trigger('focus');
        }, 100);
    }
}


/*
|--------------------------------------------------------------------------
| AGREGAR O ACUMULAR PRODUCTO
|--------------------------------------------------------------------------
*/

function agregarProducto(desdeEscaner = false) {
    const option = $('#producto_id option:selected');

    if (!option.val()) {
        showModal('Seleccione un producto');
        $('#producto_id').trigger('focus');
        return;
    }

    const idProducto = option.data('id');
    const nombreProducto = option.data('nombre');
    const presentacionProducto = option.data('sigla');
    const precioVenta = parseFloat(option.data('precio'));
    const stockRestante = obtenerStockRestante(option);
    const cantidad = parseInt($('#cantidad').val(), 10);

    if (isNaN(cantidad) || cantidad <= 0) {
        showModal('Ingrese una cantidad válida');
        $('#cantidad').trigger('focus').select();
        return;
    }

    if (
        isNaN(precioVenta) ||
        isNaN(stockRestante) ||
        !idProducto
    ) {
        showModal('No se pudieron obtener los datos del producto');
        return;
    }

    if (cantidad > stockRestante) {
        showModal(
            'Stock insuficiente. Solo quedan ' +
            stockRestante +
            ' unidad(es) disponibles.'
        );

        $('#stock').val(stockRestante);
        $('#cantidad').trigger('focus').select();
        return;
    }

    if (precioVenta < 0) {
        showModal('El precio de venta no es válido');
        return;
    }

    // Buscar si el producto ya existe en el detalle.
    let filaExistente = null;

    $('#tabla_detalle tbody tr[data-producto-id]').each(function () {
        if (
            String($(this).attr('data-producto-id')) ===
            String(idProducto)
        ) {
            filaExistente = $(this);
            return false;
        }
    });

    let cantidadFinal = cantidad;

    if (filaExistente) {
        const cantidadAnterior = parseInt(
            filaExistente.find('.cantidad-producto').text(),
            10
        ) || 0;

        cantidadFinal = cantidadAnterior + cantidad;

        const totalFila = round(cantidadFinal * precioVenta);
        const baseFila = round(totalFila / (1 + impuesto / 100));
        const igvFila = round(totalFila - baseFila);

        filaExistente
            .find('input[name="arraycantidad[]"]')
            .val(cantidadFinal);

        filaExistente
            .find('.cantidad-producto')
            .text(cantidadFinal);

        filaExistente
            .find('input[name="arrayprecioventa[]"]')
            .val(precioVenta);

        filaExistente.find('td:nth-child(5)').text(baseFila.toFixed(2));
        filaExistente.find('td:nth-child(6)').text(igvFila.toFixed(2));
        filaExistente.find('td:nth-child(7)').text(totalFila.toFixed(2));

    } else {
        const totalProducto = round(cantidad * precioVenta);
        const subtotalProducto = round(
            totalProducto / (1 + impuesto / 100)
        );
        const igvProducto = round(totalProducto - subtotalProducto);

        $('#filaVacia').remove();

        const fila =
            '<tr id="fila' + cont + '" data-producto-id="' + idProducto + '">' +

                '<td>' +
                    '<input type="hidden" name="arrayidproducto[]" value="' + idProducto + '">' +
                    nombreProducto +
                '</td>' +

                '<td>' + presentacionProducto + '</td>' +

                '<td>' +
                    '<input type="hidden" name="arraycantidad[]" value="' + cantidad + '">' +
                    '<span class="cantidad-producto">' + cantidad + '</span>' +
                '</td>' +

                '<td>' +
                    '<input type="hidden" name="arrayprecioventa[]" value="' + precioVenta + '">' +
                    precioVenta.toFixed(2) +
                '</td>' +

                '<td>' + subtotalProducto.toFixed(2) + '</td>' +
                '<td>' + igvProducto.toFixed(2) + '</td>' +
                '<td>' + totalProducto.toFixed(2) + '</td>' +

                '<td>' +
                    '<button class="btn btn-danger" type="button" onclick="eliminarProducto(' + cont + ')">' +
                        '<i class="fa-solid fa-trash"></i>' +
                    '</button>' +
                '</td>' +

            '</tr>';

        $('#tabla_detalle tbody').append(fila);
        cont++;
    }

    actualizarTotales();

    // Mostrar el stock restante del producto seleccionado.
    $('#stock').val(obtenerStockRestante(option));

    // Limpiar cantidad y preparar el siguiente ingreso.
    $('#cantidad').val('');

    if (desdeEscaner) {
        setTimeout(function () {
            $('#codigo_barras').trigger('focus');
        }, 50);
    } else {
        setTimeout(function () {
            $('#cantidad').trigger('focus').select();
        }, 50);
    }
}


/*
|--------------------------------------------------------------------------
| ACTUALIZAR TOTALES
|--------------------------------------------------------------------------
*/

function actualizarTotales() {
    sumas = 0;
    igv = 0;
    total = 0;

    $('#tabla_detalle tbody tr[data-producto-id]').each(function () {
        const baseFila = parseFloat($(this).find('td:nth-child(5)').text());
        const igvFila = parseFloat($(this).find('td:nth-child(6)').text());
        const totalFila = parseFloat($(this).find('td:nth-child(7)').text());

        if (!isNaN(baseFila)) sumas += baseFila;
        if (!isNaN(igvFila)) igv += igvFila;
        if (!isNaN(totalFila)) total += totalFila;
    });

    sumas = round(sumas);
    igv = round(igv);
    total = round(total);

    $('#sumas').text(sumas.toFixed(2));
    $('#igv').text(igv.toFixed(2));
    $('#total').text(total.toFixed(2));

    $('#inputSubtotal').val(sumas.toFixed(2));
    $('#inputImpuesto').val(igv.toFixed(2));
    $('#inputTotal').val(total.toFixed(2));

    const dineroRecibido = parseFloat($('#dinero_recibido').val());

    if (
        !isNaN(dineroRecibido) &&
        dineroRecibido >= total &&
        total > 0
    ) {
        $('#vuelto').val((dineroRecibido - total).toFixed(2));
    } else {
        $('#vuelto').val('');
    }

    mostrarValores();
    disableButtons();
}


/*
|--------------------------------------------------------------------------
| ELIMINAR PRODUCTO
|--------------------------------------------------------------------------
*/

function eliminarProducto(indice) {
    $('#fila' + indice).remove();

    if ($('#tabla_detalle tbody tr[data-producto-id]').length === 0) {
        $('#tabla_detalle tbody').html(
            '<tr id="filaVacia">' +
                '<td colspan="8" class="text-center text-muted">' +
                    'No hay productos agregados.' +
                '</td>' +
            '</tr>'
        );
    }

    actualizarTotales();
    mostrarValores();

    $('#codigo_barras').trigger('focus');
}


/*
|--------------------------------------------------------------------------
| CANCELAR VENTA
|--------------------------------------------------------------------------
*/

function cancelarVenta() {
    $('#tabla_detalle tbody').html(
        '<tr id="filaVacia">' +
            '<td colspan="8" class="text-center text-muted">' +
                'No hay productos agregados.' +
            '</td>' +
        '</tr>'
    );

    cont = 0;
    subtotal = [];
    sumas = 0;
    igv = 0;
    total = 0;

    $('#sumas').text('0.00');
    $('#igv').text('0.00');
    $('#total').text('0.00');

    $('#inputSubtotal').val('0.00');
    $('#inputImpuesto').val('0.00');
    $('#inputTotal').val('0.00');

    $('#dinero_recibido').val('');
    $('#vuelto').val('');

    limpiarCampos();
    actualizarTotales();

    $('#codigo_barras').val('').trigger('focus');
}


/*
|--------------------------------------------------------------------------
| MOSTRAR U OCULTAR BOTONES
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
| LIMPIAR CAMPOS DEL PRODUCTO
|--------------------------------------------------------------------------
*/

function limpiarCampos() {
    $('#producto_id').selectpicker('val', '');
    $('#cantidad').val('');
    $('#precio').val('');
    $('#stock').val('');
}


/*
|--------------------------------------------------------------------------
| SWEETALERT
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
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    Toast.fire({
        icon: icon,
        title: message
    });
}


/*
|--------------------------------------------------------------------------
| REDONDEAR
|--------------------------------------------------------------------------
*/

function round(num, decimales = 2) {
    const signo = num >= 0 ? 1 : -1;
    num = num * signo;

    if (decimales === 0) {
        return signo * Math.round(num);
    }

    num = num.toString().split('e');

    num = Math.round(
        +(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales))
    );

    num = num.toString().split('e');

    return signo * (
        num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales)
    );
}
