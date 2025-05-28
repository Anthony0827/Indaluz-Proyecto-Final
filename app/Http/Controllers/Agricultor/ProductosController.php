<?php

namespace App\Http\Controllers\Agricultor;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductosController extends Controller
{
    /**
     * Muestra la lista de productos del agricultor
     */
    public function index(Request $request)
    {
        $query = Producto::where('id_agricultor', Auth::id());

        // Aplicar filtros
        if ($request->filled('buscar')) {
            $buscar = $request->get('buscar');
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                  ->orWhere('descripcion', 'LIKE', "%{$buscar}%");
            });
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->get('categoria'));
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->get('estado'));
        }

        $productos = $query->orderBy('id_producto', 'desc')->paginate(12);
        
        // Mantener los parámetros de búsqueda en la paginación
        $productos->appends($request->all());

        return view('agricultor.productos.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto
     */
    public function create()
    {
        return view('agricultor.productos.create');
    }

    /**
     * Almacena un nuevo producto
     */
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:500',
            'precio' => 'required|numeric|min:0.01|max:9999.99',
            'cantidad_inventario' => 'required|numeric|min:0|max:99999',
            'unidad_medida' => 'required|in:unidad,kilogramo,gramo,manojo,docena,caja',
            'categoria' => 'required|in:fruta,verdura',
            'tiempo_de_cosecha' => 'required|string|max:50',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // 2MB máximo
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio mínimo es 0.01€.',
            'precio.max' => 'El precio máximo es 9999.99€.',
            'cantidad_inventario.required' => 'La cantidad es obligatoria.',
            'cantidad_inventario.numeric' => 'La cantidad debe ser un número.',
            'cantidad_inventario.min' => 'La cantidad no puede ser negativa.',
            'unidad_medida.required' => 'Debes seleccionar una unidad de medida.',
            'unidad_medida.in' => 'La unidad de medida no es válida.',
            'categoria.required' => 'Debes seleccionar una categoría.',
            'categoria.in' => 'La categoría seleccionada no es válida.',
            'tiempo_de_cosecha.required' => 'El tiempo de cosecha es obligatorio.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser JPEG, PNG, JPG o WEBP.',
            'imagen.max' => 'La imagen no puede pesar más de 2MB.',
        ]);

        // Procesar imagen si existe
        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = Str::slug($validated['nombre']) . '-' . time() . '.' . $imagen->getClientOriginalExtension();
            $imagenPath = $imagen->storeAs('productos', $nombreImagen, 'public');
        }

        // Crear producto
        $producto = Producto::create([
            'id_agricultor' => Auth::id(),
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'precio' => $validated['precio'],
            'cantidad_inventario' => $validated['cantidad_inventario'],
            'unidad_medida' => $validated['unidad_medida'],
            'categoria' => $validated['categoria'],
            'tiempo_de_cosecha' => $validated['tiempo_de_cosecha'],
            'imagen' => $imagenPath,
            'estado' => 'activo',
        ]);

        return redirect()
            ->route('agricultor.productos.index')
            ->with('success', '¡Producto creado exitosamente!');
    }

    /**
     * Muestra el formulario para editar un producto
     */
    public function edit($id)
    {
        $producto = Producto::where('id_agricultor', Auth::id())
            ->where('id_producto', $id)
            ->firstOrFail();

        return view('agricultor.productos.edit', compact('producto'));
    }

    /**
     * Actualiza un producto existente
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::where('id_agricultor', Auth::id())
            ->where('id_producto', $id)
            ->firstOrFail();

        // Validación
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:500',
            'precio' => 'required|numeric|min:0.01|max:9999.99',
            'cantidad_inventario' => 'required|numeric|min:0|max:99999',
            'unidad_medida' => 'required|in:unidad,kilogramo,gramo,manojo,docena,caja',
            'categoria' => 'required|in:fruta,verdura',
            'tiempo_de_cosecha' => 'required|string|max:50',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'estado' => 'required|in:activo,inactivo',
        ]);

        // Procesar nueva imagen si existe
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $imagen = $request->file('imagen');
            $nombreImagen = Str::slug($validated['nombre']) . '-' . time() . '.' . $imagen->getClientOriginalExtension();
            $validated['imagen'] = $imagen->storeAs('productos', $nombreImagen, 'public');
        }

        // Actualizar producto
        $producto->update($validated);

        return redirect()
            ->route('agricultor.productos.index')
            ->with('success', '¡Producto actualizado exitosamente!');
    }

    /**
     * Elimina un producto (cambio de estado)
     */
    public function destroy($id)
    {
        $producto = Producto::where('id_agricultor', Auth::id())
            ->where('id_producto', $id)
            ->firstOrFail();

        // En lugar de eliminar, cambiar estado a inactivo
        $producto->update(['estado' => 'inactivo']);

        return redirect()
            ->route('agricultor.productos.index')
            ->with('success', 'Producto desactivado correctamente.');
    }

    /**
     * Reactiva un producto inactivo
     */
    public function reactivate($id)
    {
        $producto = Producto::where('id_agricultor', Auth::id())
            ->where('id_producto', $id)
            ->firstOrFail();

        $producto->update(['estado' => 'activo']);

        return redirect()
            ->route('agricultor.productos.index')
            ->with('success', 'Producto reactivado correctamente.');
    }

    /**
     * Actualiza el stock de un producto (AJAX)
     */
    public function updateStock(Request $request, $id)
    {
        $producto = Producto::where('id_agricultor', Auth::id())
            ->where('id_producto', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'cantidad' => 'required|numeric|min:0|max:99999',
        ]);

        $producto->update(['cantidad_inventario' => $validated['cantidad']]);

        return response()->json([
            'success' => true,
            'message' => 'Stock actualizado correctamente',
            'nuevo_stock' => $producto->cantidad_inventario,
        ]);
    }
}