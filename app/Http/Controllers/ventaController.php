<?php

namespace App\Http\Controllers;

use App\Enums\MetodoPagoEnum;
use App\Events\CreateVentaDetalleEvent;
use App\Events\CreateVentaEvent;
use App\Http\Requests\StoreVentaRequest;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Producto;
use App\Models\Venta;
use App\Services\ActivityLogService;
use App\Services\ComprobanteService;
use App\Services\EmpresaService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Facades\Http;

class ventaController extends Controller
{
    protected EmpresaService $empresaService;

    function __construct(EmpresaService $empresaService)
    {
        $this->middleware('permission:ver-venta|crear-venta|mostrar-venta|eliminar-venta', ['only' => ['index']]);
        $this->middleware('permission:crear-venta', ['only' => ['create', 'store']]);
        $this->middleware('permission:mostrar-venta', ['only' => ['show']]);
        $this->middleware('check-caja-aperturada-user', ['only' => ['create', 'store']]);
        $this->middleware('check-show-venta-user', ['only' => ['show']]);
        $this->empresaService = $empresaService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $ventas = Venta::with(['comprobante', 'cliente.persona', 'user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('venta.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ComprobanteService $comprobanteService): View
    {

        $productos = Producto::join('inventario as i', function ($join) {
            $join->on('i.producto_id', '=', 'productos.id');
        })
            ->join('presentaciones as p', function ($join) {
                $join->on('p.id', '=', 'productos.presentacione_id');
            })
            ->select(
                'p.sigla',
                'productos.nombre',
                'productos.codigo',
                'productos.id',
                'i.cantidad',
                'productos.precio'
            )
            ->where('productos.estado', 1)
            ->where('i.cantidad', '>', 0)
            ->get();

        $clientes = Cliente::whereHas('persona', function ($query) {
            $query->where('estado', 1);
        })->get();
        $comprobantes = $comprobanteService->obtenerComprobantes();
        $optionsMetodoPago = MetodoPagoEnum::cases();
        $empresa = $this->empresaService->obtenerEmpresa();

        return view('venta.create', compact(
            'productos',
            'clientes',
            'comprobantes',
            'optionsMetodoPago',
            'empresa'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    
 
    public function store(StoreVentaRequest $request): RedirectResponse
    {
        $datos = $request->validated();

        $request->validate([
            'arrayidproducto' => ['required', 'array', 'min:1'],
            'arrayidproducto.*' => ['required', 'integer', 'distinct', 'exists:productos,id'],
            'arraycantidad' => ['required', 'array', 'min:1'],
            'arraycantidad.*' => ['required', 'numeric', 'min:1'],
            'arrayprecioventa' => ['required', 'array', 'min:1'],
            'arrayprecioventa.*' => ['required', 'numeric', 'min:0'],
        ]);

        $productos = $request->input('arrayidproducto');
        $cantidades = $request->input('arraycantidad');

        if (
            count($productos) !== count($cantidades) ||
            count($productos) !== count($request->input('arrayprecioventa'))
        ) {
            return back()
                ->withInput()
                ->with('error', 'Los datos de los productos no coinciden.');
        }

        // Obtener los datos del comprador.
        $dni = $request->input('dni_simple')
            ?: $request->input('dni_nota');

        $nombre = $request->input('nombre_simple')
            ?: $request->input('nombre_nota');

        $apellidos = $request->input('apellidos_simple')
            ?: $request->input('apellidos_nota');

        $ruc = $request->input('ruc_factura');
        $razonSocial = $request->input('razon_social_factura');
        $direccion = $request->input('direccion_factura');

        if ($ruc || $razonSocial || $direccion) {
            $datos['tipo_documento_cliente'] = 'RUC';
            $datos['numero_documento_cliente'] = $ruc;
            $datos['razon_social_cliente'] = $razonSocial;
            $datos['direccion_cliente'] = $direccion;
            $datos['nombres_cliente'] = null;
            $datos['apellidos_cliente'] = null;
            $datos['cliente_id'] = null;
        } elseif ($dni || $nombre || $apellidos) {
            $datos['tipo_documento_cliente'] = 'DNI';
            $datos['numero_documento_cliente'] = $dni;
            $datos['nombres_cliente'] = $nombre;
            $datos['apellidos_cliente'] = $apellidos;
            $datos['razon_social_cliente'] = null;
            $datos['direccion_cliente'] = null;
            $datos['cliente_id'] = null;
        }

        DB::beginTransaction();

        try {
            // Obtener el porcentaje de IGV configurado en la empresa.
            $porcentajeImpuesto = (float) (
                Empresa::query()->value('porcentaje_impuesto') ?? 18
            );

            if ($porcentajeImpuesto < 0) {
                throw new \RuntimeException('El porcentaje de impuesto no es válido.');
            }

            // Obtener los precios reales desde la base de datos.
            $productosBD = Producto::whereIn('id', $productos)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $subtotal = 0;
            $impuesto = 0;
            $total = 0;

            foreach ($productos as $indice => $productoId) {
                $producto = $productosBD->get($productoId);

                if (!$producto) {
                    throw new \RuntimeException(
                        'No se encontró uno de los productos de la venta.'
                    );
                }

                $cantidad = (float) $cantidades[$indice];
                $precioVenta = (float) $producto->precio;

                // El precio del producto ya incluye IGV.
                $totalProducto = round($cantidad * $precioVenta, 2);

                $subtotalProducto = round(
                    $totalProducto / (1 + ($porcentajeImpuesto / 100)),
                    2
                );

                $igvProducto = round(
                    $totalProducto - $subtotalProducto,
                    2
                );

                $subtotal += $subtotalProducto;
                $impuesto += $igvProducto;
                $total += $totalProducto;
            }

            // Redondear los importes finales.
            $subtotal = round($subtotal, 2);
            $impuesto = round($impuesto, 2);
            $total = round($total, 2);

            // Calcular el vuelto en el servidor.
            $montoRecibido = round(
                (float) $request->input('monto_recibido', 0),
                2
            );

            if ($montoRecibido < $total) {
                DB::rollBack();

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'El dinero recibido no puede ser menor que el total de la venta.'
                    );
            }

            $datos['subtotal'] = $subtotal;
            $datos['impuesto'] = $impuesto;
            $datos['total'] = $total;
            $datos['monto_recibido'] = $montoRecibido;
            $datos['vuelto_entregado'] = round(
                $montoRecibido - $total,
                2
            );
            // Copiar los datos del cliente seleccionado a la venta
            if (!empty($datos['cliente_id'])) {
                $cliente = Cliente::with('persona.documento')
                    ->findOrFail($datos['cliente_id']);

                $persona = $cliente->persona;

                if ($persona) {
                    $datos['tipo_documento_cliente'] = $persona->documento->nombre ?? null;
                    $datos['numero_documento_cliente'] = $persona->numero_documento;
                    $datos['nombres_cliente'] = $persona->nombres ?? null;
                    $datos['apellidos_cliente'] = $persona->apellidos ?? null;
                    $datos['razon_social_cliente'] = $persona->razon_social;
                }
            }
            // Registrar la venta. El observer conserva caja y numeración.
            $venta = Venta::create($datos);

            // Registrar el detalle y ejecutar los eventos existentes.
            foreach ($productos as $indice => $productoId) {
                $cantidad = $cantidades[$indice];
                $precioVenta = (float) $productosBD->get($productoId)->precio;

                $venta->productos()->syncWithoutDetaching([
                    $productoId => [
                        'cantidad' => $cantidad,
                        'precio_venta' => $precioVenta,
                    ],
                ]);

                CreateVentaDetalleEvent::dispatch(
                    $venta,
                    $productoId,
                    $cantidad,
                    $precioVenta
                );
            }

            CreateVentaEvent::dispatch($venta);

            DB::commit();

            ActivityLogService::log(
                'Creación de una venta',
                'Ventas',
                $datos
            );

            return redirect()
                ->route('movimientos.index', [
                    'caja_id' => $venta->caja_id,
                ])
                ->with('success', 'Venta registrada correctamente.');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Error al crear la venta', [
                'error' => $e->getMessage(),
                'comprobante_id' => $request->input('comprobante_id'),
                'datos_venta' => $datos,
            ]);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo registrar la venta. Verifica los datos e inténtalo nuevamente.'
                );
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Venta $venta): View
    {
        $empresa =  $this->empresaService->obtenerEmpresa();
        return view('venta.show', compact('venta', 'empresa'));
    }


    public function consultarDni(Request $request)
    {
        $validacion = $request->validate([
            'dni' => ['required', 'digits:8'],
        ]);

        $token = env('APIS_NET_PE_TOKEN');

        if (empty($token)) {
            return response()->json([
                'error' => 'La API no está configurada.'
            ], 500);
        }

        try {
            $respuesta = Http::withToken($token)
                ->acceptJson()
                ->timeout(10)
                ->get('https://api.apis.net.pe/v2/reniec/dni', [
                    'numero' => $validacion['dni'],
                ]);

            if (!$respuesta->successful()) {
                Log::error('Error al consultar DNI', [
                    'status' => $respuesta->status(),
                    'respuesta' => $respuesta->json(),
                ]);

                return response()->json([
                    'error' => 'No se pudo consultar el DNI. Verifica el token y la respuesta de la API.'
                ], 502);
            }

            $datos = $respuesta->json();

            $nombres = $datos['nombres'] ?? '';
            $apellidoPaterno = $datos['apellidoPaterno'] ?? '';
            $apellidoMaterno = $datos['apellidoMaterno'] ?? '';

            $apellidos = trim($apellidoPaterno . ' ' . $apellidoMaterno);

            if ($apellidos === '' && !empty($datos['apellidos'])) {
                $apellidos = $datos['apellidos'];
            }

            if ($nombres === '' && $apellidos === '') {
                Log::error('Respuesta DNI sin nombres reconocibles', [
                    'respuesta' => $datos,
                ]);

                return response()->json([
                    'error' => 'La API respondió sin los nombres esperados.'
                ], 502);
            }

            return response()->json([
                'dni' => $datos['numeroDocumento'] ?? $validacion['dni'],
                'nombre' => $nombres,
                'apellido' => $apellidos,
            ]);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Error de conexión al consultar DNI', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'No se pudo conectar con el servicio de consulta.'
            ], 504);
        }
    }

    public function consultarRuc(Request $request)
    {
        $validacion = $request->validate([
            'ruc' => ['required', 'digits:11'],
        ]);

        $token = env('APIS_NET_PE_TOKEN');

        if (empty($token)) {
            return response()->json([
                'error' => 'La API no está configurada.'
            ], 500);
        }

        try {
            $respuesta = Http::withToken($token)
                ->acceptJson()
                ->timeout(10)
                ->get('https://api.apis.net.pe/v2/sunat/ruc', [
                    'numero' => $validacion['ruc'],
                ]);

            if (!$respuesta->successful()) {
                Log::error('Error al consultar RUC', [
                    'status' => $respuesta->status(),
                    'respuesta' => $respuesta->json(),
                ]);

                return response()->json([
                    'error' => 'No se encontró el RUC o no se pudo consultar la API.'
                ], 502);
            }

            $datos = $respuesta->json();

            $razonSocial = $datos['razonSocial'] ?? '';
            $direccion = $datos['direccion'] ?? '';

            if (empty($razonSocial)) {
                Log::error('Respuesta RUC sin razón social', [
                    'respuesta' => $datos,
                ]);

                return response()->json([
                    'error' => 'La API no devolvió la razón social.'
                ], 502);
            }

            return response()->json([
                'ruc' => $datos['numeroDocumento']
                    ?? $datos['ruc']
                    ?? $validacion['ruc'],
                'razon_social' => $razonSocial,
                'direccion' => $direccion,
            ]);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Error de conexión al consultar RUC', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'No se pudo conectar con el servicio de consulta.'
            ], 504);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /* Venta::where('id', $id)
            ->update([
                'estado' => 0
            ]);

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada');*/
    }
}
