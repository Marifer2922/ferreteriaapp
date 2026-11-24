<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProductoResource;

class ProductoController extends Controller
{
    // GET /api/productos
    public function index(): JsonResponse
    {
        $productos = Producto::orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'status' => 'success',
            'data'   => ProductoResource::collection($productos),
            'pagination' => [
                'total'        => $productos->total(),
                'per_page'     => $productos->perPage(),
                'current_page' => $productos->currentPage(),
                'last_page'    => $productos->lastPage(),
            ]
        ], 200);
    }

    // POST /api/productos
    public function store(Request $request): JsonResponse
    {
        $validados = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0.01',
            'stock'       => 'required|integer|min:0',
        ]);

        $producto = Producto::create($validados);

        return response()->json([
            'status'  => 'created',
            'message' => 'Artículo ingresado exitosamente al inventario de Ferretería La Bendición',
            'data'    => new ProductoResource($producto)
        ], 201);
    }

    // GET /api/productos/{id}
    public function show(string $id): JsonResponse
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status'  => 'error',
                'message' => "El producto con ID #{$id} no existe en Ferretería La Bendición"
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => new ProductoResource($producto)
        ], 200);
    }

    // PUT/PATCH /api/productos/{id}
    public function update(Request $request, string $id): JsonResponse
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Producto no encontrado para actualizar'
            ], 404);
        }

        $validados = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0.01',
            'stock'       => 'required|integer|min:0',
        ]);

        $producto->update($validados);

        return response()->json([
            'status'  => 'updated',
            'message' => 'Producto actualizado correctamente',
            'data'    => new ProductoResource($producto)
        ], 200);
    }

    // DELETE /api/productos/{id}
    public function destroy(string $id): JsonResponse
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status'  => 'error',
                'message' => 'El producto a eliminar no existe en bodega'
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'status'  => 'deleted',
            'message' => 'Producto dado de baja exitosamente'
        ], 200);
    }
}