<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Controlador de la API para el acceso público a las páginas estáticas.
 * Endpoints disponibles sin autenticación.
 *
 * @group Páginas
 */
class PageApiController extends Controller
{
    /**
     * Devuelve un listado paginado de páginas publicadas y activas.
     *
     * @unauthenticated
     *
     * @param  Request  $request  La petición HTTP con parámetros de paginación
     * @return JsonResponse Listado paginado de páginas con sus categorías
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->get('per_page', 12), 50);

        $pages = Page::publishedAndActive()
            ->with('categories:id,slug,name')
            ->orderByDesc('published_at')
            ->paginate($perPage);

        return response()->json($pages);
    }

    /**
     * Devuelve el detalle de una página específica identificada por su slug.
     * Devuelve 404 si la página no existe, no está publicada o no está activa.
     *
     * @unauthenticated
     *
     * @param  string  $slug  El slug único de la página
     * @return JsonResponse Datos completos de la página con sus relaciones
     */
    public function show(string $slug): JsonResponse
    {
        $page = Page::where('slug', $slug)
            ->publishedAndActive()
            ->with('categories:id,slug,name')
            ->firstOrFail();

        return response()->json($page);
    }
}
