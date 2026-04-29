<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

/**
 * Controlador para las páginas estáticas del sitio web: About, Privacy y Cookies.
 * Cada página carga contenido dinámico desde las secciones de su zona correspondiente.
 */
class StaticPageController extends Controller
{
    /**
     * Muestra la página "Sobre nosotros".
     * Las secciones se obtienen desde la base de datos filtradas por zone='about'.
     *
     * @param  SeoService  $seo  Servicio para gestión de meta tags SEO
     * @return View              Vista de la página about
     */
    public function about(SeoService $seo): View
    {
        // Cargar secciones de la zona 'about' con caché de IDs
        $sectionIds = Cache::remember('sections_about_ids', 3600, fn () => Section::forZone('about')->pluck('id')->all());
        $sections = Section::whereIn('id', $sectionIds)->orderBy('order')->get();

        $seo->setTitle(__('messages.about') . ' - ' . setting('site_title'));
        return view('about', compact('sections', 'seo'));
    }

    /**
     * Muestra la página de Política de Privacidad.
     * El contenido se obtiene desde secciones de la zona 'privacy'.
     *
     * @param  SeoService  $seo  Servicio para gestión de meta tags SEO
     * @return View              Vista de la página de privacidad
     */
    public function privacy(SeoService $seo): View
    {
        $sectionIds = Cache::remember('sections_privacy_ids', 3600, fn () => Section::forZone('privacy')->pluck('id')->all());
        $sections = Section::whereIn('id', $sectionIds)->orderBy('order')->get();

        $seo->setTitle(__('messages.privacy') . ' - ' . setting('site_title'))
            ->setRobots('noindex,follow');

        return view('privacy', compact('sections', 'seo'));
    }

    /**
     * Muestra la página de Política de Cookies.
     * El contenido se obtiene desde secciones de la zona 'cookies'.
     *
     * @param  SeoService  $seo  Servicio para gestión de meta tags SEO
     * @return View              Vista de la página de cookies
     */
    public function cookies(SeoService $seo): View
    {
        $sectionIds = Cache::remember('sections_cookies_ids', 3600, fn () => Section::forZone('cookies')->pluck('id')->all());
        $sections = Section::whereIn('id', $sectionIds)->orderBy('order')->get();

        $seo->setTitle(__('messages.cookies') . ' - ' . setting('site_title'))
            ->setRobots('noindex,follow');

        return view('cookies', compact('sections', 'seo'));
    }
}
