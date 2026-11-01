<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;

/**
 * Controlador para las páginas dinámicas del frontend.
 * Las páginas son contenido editable desde el backend Filament.
 */
class PageController extends Controller
{
    /**
     * Muestra el detalle de una página dinámica por su slug.
     * Devuelve 404 si la página no existe, no está publicada o no está activa.
     *
     * @param  string  $slug  El slug de la página
     * @param  SeoService  $seo  Servicio para gestión de meta tags SEO
     * @return View Vista del detalle de la página
     */
    public function show(string $slug, SeoService $seo): View
    {
        // Buscar página publicada y activa por slug
        $page = Page::where('slug', $slug)
            ->publishedAndActive()
            ->firstOrFail();

        // Configurar SEO dinámico a partir de los campos de la página
        $seo->fromModel($page)
            ->setType('article')
            ->setUrl(url("/pages/{$page->slug}"));

        return view('pages.show', compact('page', 'seo'));
    }
}
