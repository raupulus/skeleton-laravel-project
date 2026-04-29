<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Controlador de la API para el acceso público a los posts del blog.
 * Endpoints disponibles sin autenticación.
 *
 * @group Posts
 */
class PostApiController extends Controller
{
    /**
     * Devuelve un listado paginado de posts publicados y activos.
     * Soporta paginación con parámetro per_page (máximo 50 por página).
     *
     * @unauthenticated
     * @param  Request  $request  La petición HTTP con parámetros de paginación
     * @return JsonResponse       Listado paginado de posts con sus categorías
     */
    public function index(Request $request): JsonResponse
    {
        // Limitar el número máximo de resultados por página a 50
        $perPage = min((int) $request->get('per_page', 12), 50);

        $posts = Post::publishedAndActive()
            ->with('categories:id,slug,name')
            ->orderByDesc('published_at')
            ->paginate($perPage);

        return response()->json($posts);
    }

    /**
     * Devuelve el detalle de un post específico identificado por su slug.
     * Devuelve 404 si el post no existe, no está publicado o no está activo.
     *
     * @unauthenticated
     * @param  string  $slug  El slug único del post
     * @return JsonResponse   Datos completos del post con sus relaciones
     */
    public function show(string $slug): JsonResponse
    {
        $post = Post::where('slug', $slug)
            ->publishedAndActive()
            ->with('categories:id,slug,name', 'user:id,name')
            ->firstOrFail();

        return response()->json($post);
    }
}
