<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInventarioRequest;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Ubicacione;
use App\Services\ActivityLogService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class InventarioController extends Controller
{
    /**
     * Constructor del controlador.
     */
    public function __construct()
    {
        $this->middleware('check_producto_inicializado', [
            'only' => ['create', 'store']
        ]);
    }

    /**
     * Mostrar el listado de inventarios.
     */
    public function index(): View
    {
        $inventario = Inventario::latest()->get();

        return view('inventario.index', compact('inventario'));
    }

    /**
     * Mostrar el formulario para inicializar un producto.
     */
    public function create(Request $request): View
    {
        $producto = Producto::findOrFail($request->producto_id);

        $ubicaciones = Ubicacione::all();

        return view(
            'inventario.create',
            compact('producto', 'ubicaciones')
        );
    }

    /**
     * Crear el registro inicial del inventario.
     *
     * La inicialización no registra mercadería.
     * La cantidad inicial es 0.
     */
    public function store(StoreInventarioRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {

            $datos = $request->validated();

            // Crear el inventario con cantidad inicial en cero.
            $inventario = Inventario::create([
                'producto_id' => $datos['producto_id'],
                'ubicacione_id' => $datos['ubicacione_id'],
                'cantidad' => 0,
                'fecha_vencimiento' => null,
            ]);

            // Buscar el producto.
            $producto = Producto::findOrFail($datos['producto_id']);

            // Marcar el producto como inicializado.
            $producto->update([
                'estado' => 1,
            ]);

            DB::commit();

            // Registrar la actividad.
            ActivityLogService::log(
                'Inicialización de producto',
                'Productos',
                [
                    'producto_id' => $producto->id,
                    'ubicacione_id' => $inventario->ubicacione_id,
                    'cantidad_inicial' => 0,
                ]
            );

            return redirect()
                ->route('productos.index')
                ->with(
                    'success',
                    'Producto inicializado correctamente.'
                );

        } catch (Throwable $e) {

            DB::rollBack();

            Log::error('Error al inicializar el producto', [
                'error' => $e->getMessage(),
                'producto_id' => $request->producto_id,
            ]);

            return redirect()
                ->route('productos.index')
                ->with(
                    'error',
                    'ERROR: ' . $e->getMessage()
                );
        }
    }

    /**
     * Mostrar un inventario específico.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Mostrar el formulario para editar un inventario.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Actualizar un inventario.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Eliminar un inventario.
     */
    public function destroy(string $id)
    {
        //
    }
}