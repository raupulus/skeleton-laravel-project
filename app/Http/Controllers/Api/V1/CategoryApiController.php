<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

/**
 * Controlador de la API para el acceso público a las categorías.
 * Las categorías son compartidas entre posts y páginas.
 *
 * @group Categorías
 */
class CategoryApiController extends Controller
{
    /**
     * Devuelve el listado completo de categorías activas ordenadas por orden.
     * Las categorías no se paginan ya que su número suele ser reducido.
     *
     * @unauthenticated
     *
     * @return JsonResponse Listado de categorías activas
     */
    public function index(): JsonResponse
    {
        $categories = Category::active()->ordered()->get();

        return response()->json($categories);
    }

    /**
     * Devuelve el detalle de una categoría específica identificada por su slug.
     * Devuelve 404 si la categoría no existe o no está activa.
     *
     * @unauthenticated
     *
     * @param  string  $slug  El slug único de la categoría
     * @return JsonResponse Datos de la categoría
     */
    public function show(string $slug): JsonResponse
    {
        $category = Category::where('slug', $slug)->active()->firstOrFail();

        return response()->json($category);
    }
}
