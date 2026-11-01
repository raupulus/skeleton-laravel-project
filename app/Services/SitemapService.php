<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Post;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

/**
 * Servicio para la generación del sitemap XML del sitio web.
 * Genera un sitemap con todas las URLs públicas del sitio:
 * páginas estáticas, posts publicados y páginas dinámicas.
 * Incluye alternates hreflang para multi-idioma (es/en).
 * Se genera en public/sitemap.xml y es invocado por el comando sitemap:generate.
 */
class SitemapService
{
    /**
     * Genera el archivo sitemap.xml con todas las URLs públicas del sitio.
     * Incluye rutas estáticas, posts publicados y páginas publicadas.
     * Cada URL incluye alternates hreflang para todos los idiomas soportados.
     */
    public function generate(): void
    {
        $sitemap = Sitemap::create();

        // Añadir URLs estáticas del sitio
        $this->addStaticUrls($sitemap);

        // Añadir posts publicados con sus metadatos
        $this->addPosts($sitemap);

        // Añadir páginas dinámicas publicadas
        $this->addPages($sitemap);

        // Guardar el sitemap en el directorio público
        $sitemap->writeToFile(public_path('sitemap.xml'));
    }

    /**
     * Añade alternates hreflang multi-idioma a una URL.
     * Genera URLs con el parámetro `?lang=XX` para cada idioma soportado.
     *
     * @param  Url  $url  El objeto URL al que añadir los alternates
     * @param  string  $baseUrl  La URL base sin parámetros de idioma
     * @return Url El objeto URL con los alternates añadidos
     */
    private function addHreflangAlternates(Url $url, string $baseUrl): Url
    {
        foreach (config('locales.available', ['es', 'en']) as $locale) {
            $url->addAlternate(
                url: $baseUrl.'?lang='.$locale,
                locale: $locale
            );
        }

        return $url;
    }

    /**
     * Añade las URLs estáticas del sitio al sitemap.
     * Incluye: home, blog, about, contact.
     *
     * @param  Sitemap  $sitemap  El objeto sitemap en construcción
     */
    private function addStaticUrls(Sitemap $sitemap): void
    {
        $homeUrl = url('/');
        $sitemap->add(
            $this->addHreflangAlternates(
                Url::create($homeUrl)
                    ->setLastModificationDate(now())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(1.0),
                $homeUrl
            )
        );

        $blogUrl = route('blog.index');
        $sitemap->add(
            $this->addHreflangAlternates(
                Url::create($blogUrl)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.8),
                $blogUrl
            )
        );

        $aboutUrl = route('about');
        $sitemap->add(
            $this->addHreflangAlternates(
                Url::create($aboutUrl)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.5),
                $aboutUrl
            )
        );

        $contactUrl = route('contact');
        $sitemap->add(
            $this->addHreflangAlternates(
                Url::create($contactUrl)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.4),
                $contactUrl
            )
        );
    }

    /**
     * Añade todos los posts publicados al sitemap con metadatos apropiados.
     * Usa la fecha de actualización para lastmod y prioridad 0.7 por defecto.
     *
     * @param  Sitemap  $sitemap  El objeto sitemap en construcción
     */
    private function addPosts(Sitemap $sitemap): void
    {
        Post::publishedAndActive()
            ->orderByDesc('published_at')
            ->each(function (Post $post) use ($sitemap): void {
                $postUrl = route('blog.show', $post->slug);
                $sitemap->add(
                    $this->addHreflangAlternates(
                        Url::create($postUrl)
                            ->setLastModificationDate($post->updated_at)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                            ->setPriority(0.7),
                        $postUrl
                    )
                );
            });
    }

    /**
     * Añade todas las páginas dinámicas publicadas al sitemap.
     * Las páginas tienen prioridad 0.6 por ser contenido más estático.
     *
     * @param  Sitemap  $sitemap  El objeto sitemap en construcción
     */
    private function addPages(Sitemap $sitemap): void
    {
        Page::publishedAndActive()
            ->each(function (Page $page) use ($sitemap): void {
                $pageUrl = route('pages.show', $page->slug);
                $sitemap->add(
                    $this->addHreflangAlternates(
                        Url::create($pageUrl)
                            ->setLastModificationDate($page->updated_at)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                            ->setPriority(0.6),
                        $pageUrl
                    )
                );
            });
    }
}
