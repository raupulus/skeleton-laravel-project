<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;

/**
 * Controlador para las vistas públicas del blog (listado y detalle de posts).
 */
class PostController extends Controller
{
    /**
     * Muestra el listado paginado de posts publicados.
     *
     * @param  SeoService  $seo  Servicio para gestión de meta tags SEO
     * @return View Vista del listado de posts
     */
    public function index(SeoService $seo): View
    {
        // Obtener posts publicados con eager loading de relaciones necesarias
        $posts = Post::publishedAndActive()
            ->with('categories:id,slug,name', 'user:id,name')
            ->orderByDesc('published_at')
            ->paginate(12);

        $currentPage = $posts->currentPage();
        $baseTitle = __('messages.blog').' - '.setting('site_title', config('app.name'));
        $title = $currentPage > 1
            ? __('messages.blog').' ('.__('messages.page_number', ['page' => $currentPage]).') - '.setting('site_title', config('app.name'))
            : $baseTitle;

        $seo->setTitle($title)
            ->setDescription(__('messages.blog_seo_description'))
            ->setUrl($currentPage > 1 ? $posts->url($currentPage) : route('blog.index'))
            ->setBreadcrumbs([
                ['name' => __('messages.home'), 'url' => route('home')],
                ['name' => __('messages.blog'), 'url' => route('blog.index')],
            ]);

        return view('posts.index', compact('posts', 'seo'));
    }

    /**
     * Muestra el detalle de un post específico por su slug.
     * Devuelve 404 si el post no existe, no está publicado o no está activo.
     *
     * @param  string  $slug  El slug del post
     * @param  SeoService  $seo  Servicio para gestión de meta tags SEO
     * @return View Vista del detalle del post
     */
    public function show(string $slug, SeoService $seo): View
    {
        // Buscar post publicado y activo, con eager loading de sus relaciones
        $post = Post::where('slug', $slug)
            ->publishedAndActive()
            ->with('categories:id,slug,name', 'user:id,name')
            ->firstOrFail();

        // Configurar SEO dinámico a partir de los campos del post
        $seo->fromModel($post)
            ->setType('article')
            ->setUrl(route('blog.show', $post->slug))
            ->setBreadcrumbs([
                ['name' => __('messages.home'), 'url' => route('home')],
                ['name' => __('messages.blog'), 'url' => route('blog.index')],
                ['name' => $post->title, 'url' => route('blog.show', $post->slug)],
            ]);

        return view('posts.show', compact('post', 'seo'));
    }
}
