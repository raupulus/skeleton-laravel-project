<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Support\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

/**
 * Servicio para la generación del sitemap XML del sitio web.
 * Genera un sitemap con todas las URLs públicas indexables del sitio:
 * páginas estáticas, posts publicados y páginas dinámicas (excluyendo legales con noindex).
 * Incluye alternates hreflang para multi-idioma (es/en) y x-default.
 */
class SitemapService
{
    /**
     * Slugs de páginas legales que llevan directiva noindex,follow y no deben incluirse en el sitemap.
     *
     * @var array<int, string>
     */
    private const NOINDEX_PAGE_SLUGS = [
        'privacy',
        'cookies',
        'terms',
    ];

    /**
     * Genera el archivo sitemap.xml con todas las URLs públicas indexables del sitio.
     */
    public function generate(): void
    {
        $sitemap = Sitemap::create();

        // Añadir URLs estáticas del sitio
        $this->addStaticUrls($sitemap);

        // Añadir posts publicados con sus metadatos
        $this->addPosts($sitemap);

        // Añadir páginas dinámicas publicadas (excluyendo páginas legales noindex)
        $this->addPages($sitemap);

        // Guardar el sitemap en el directorio público
        $sitemap->writeToFile(public_path('sitemap.xml'));
    }

    /**
     * Añade alternates hreflang multi-idioma y x-default a una URL.
     */
    private function addHreflangAlternates(Url $url, string $baseUrl): Url
    {
        foreach (config('locales.available', ['es', 'en']) as $locale) {
            $url->addAlternate(
                url: $baseUrl.'?lang='.$locale,
                locale: $locale
            );
        }

        $url->addAlternate(
            url: $baseUrl,
            locale: 'x-default'
        );

        return $url;
    }

    /**
     * Añade las URLs estáticas del sitio al sitemap con lastmod real.
     */
    private function addStaticUrls(Sitemap $sitemap): void
    {
        $latestPostDate = Post::publishedAndActive()->max('updated_at');
        $lastMod = $latestPostDate ? Carbon::parse($latestPostDate) : now();

        $homeUrl = url('/');
        $sitemap->add(
            $this->addHreflangAlternates(
                Url::create($homeUrl)
                    ->setLastModificationDate($lastMod)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(1.0),
                $homeUrl
            )
        );

        $blogUrl = route('blog.index');
        $sitemap->add(
            $this->addHreflangAlternates(
                Url::create($blogUrl)
                    ->setLastModificationDate($lastMod)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.8),
                $blogUrl
            )
        );

        $aboutUrl = route('about');
        $sitemap->add(
            $this->addHreflangAlternates(
                Url::create($aboutUrl)
                    ->setLastModificationDate($lastMod)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.5),
                $aboutUrl
            )
        );

        $contactUrl = route('contact');
        $sitemap->add(
            $this->addHreflangAlternates(
                Url::create($contactUrl)
                    ->setLastModificationDate($lastMod)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.4),
                $contactUrl
            )
        );
    }

    /**
     * Añade todos los posts publicados al sitemap usando chunking para eficiencia en memoria ([BDB-04]).
     */
    private function addPosts(Sitemap $sitemap): void
    {
        Post::publishedAndActive()
            ->orderByDesc('published_at')
            ->chunk(200, function ($posts) use ($sitemap): void {
                foreach ($posts as $post) {
                    $postUrl = route('blog.show', $post->slug);
                    $sitemap->add(
                        $this->addHreflangAlternates(
                            Url::create($postUrl)
                                ->setLastModificationDate($post->updated_at ?? now())
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                                ->setPriority(0.7),
                            $postUrl
                        )
                    );
                }
            });
    }

    /**
     * Añade todas las páginas dinámicas publicadas al sitemap (excluyendo páginas con noindex).
     */
    private function addPages(Sitemap $sitemap): void
    {
        Page::publishedAndActive()
            ->whereNotIn('slug', self::NOINDEX_PAGE_SLUGS)
            ->chunk(200, function ($pages) use ($sitemap): void {
                foreach ($pages as $page) {
                    $pageUrl = route('pages.show', $page->slug);
                    $sitemap->add(
                        $this->addHreflangAlternates(
                            Url::create($pageUrl)
                                ->setLastModificationDate($page->updated_at ?? now())
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                                ->setPriority(0.6),
                            $pageUrl
                        )
                    );
                }
            });
    }
}
