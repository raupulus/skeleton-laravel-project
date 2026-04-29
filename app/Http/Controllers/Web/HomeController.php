<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Section;
use App\Models\Slide;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

/**
 * Controlador para la página de inicio del sitio web.
 * Carga las secciones dinámicas, slides y últimos posts publicados.
 */
class HomeController extends Controller
{
    /**
     * Muestra la página principal del sitio.
     *
     * @param  SeoService  $seo  Servicio para gestión de meta tags SEO
     * @return View              Vista de la página de inicio
     */
    public function index(SeoService $seo): View
    {
        // Cargar secciones de la zona home con caché de IDs (1 hora)
        $sectionIds = Cache::remember('sections_home_ids', 3600, fn () => Section::forZone('home')->pluck('id')->all());
        $sections = Section::whereIn('id', $sectionIds)->orderBy('order')->get();

        // Cargar slides de la zona home con caché de IDs (1 hora)
        $slideIds = Cache::remember('slides_home_ids', 3600, fn () => Slide::forZone('home')->pluck('id')->all());
        $slides = Slide::whereIn('id', $slideIds)->orderBy('order')->get();

        // Obtener los últimos 6 posts publicados con sus categorías (eager loading para evitar N+1)
        $latestPosts = Post::publishedAndActive()
            ->with('categories:id,slug,name')
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        // Configurar meta tags SEO con los datos del sitio
        $seo->setTitle(setting('site_title', config('app.name')))
            ->setDescription(setting('site_description', ''));

        return view('home', compact('sections', 'slides', 'latestPosts', 'seo'));
    }
}
