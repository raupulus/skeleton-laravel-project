<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
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
     * Soporta paginación con parámetro per_page (entre 1 y 50 por página).
     *
     * @unauthenticated
     *
     * @param  Request  $request  La petición HTTP con parámetros de paginación
     * @return JsonResponse Listado paginado de posts con sus categorías
     */
    public function index(Request $request): JsonResponse
    {
        // Acotar el número de resultados por página entre 1 y 50
        $perPage = max(1, min($request->integer('per_page', 12), 50));

        $posts = Post::publishedAndActive()
            ->with('categories:id,slug,name')
            ->orderByDesc('published_at')
            ->paginate($perPage)
            ->through(fn (Post $post) => (new PostResource($post))->resolve());

        return response()->json($posts);
    }

    /**
     * Devuelve el detalle de un post específico identificado por su slug.
     * Devuelve 404 si el post no existe, no está publicado o no está activo.
     *
     * @unauthenticated
     *
     * @param  string  $slug  El slug único del post
     * @return JsonResponse Datos completos del post con sus relaciones
     */
    public function show(string $slug): JsonResponse
    {
        $post = Post::where('slug', $slug)
            ->publishedAndActive()
            ->with('categories:id,slug,name', 'user:id,name')
            ->firstOrFail();

        return response()->json(new PostResource($post));
    }
}
