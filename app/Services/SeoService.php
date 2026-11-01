<?php

namespace App\Services;

/**
 * Servicio para la gestión dinámica de meta tags SEO y Schema.org JSON-LD.
 * Acumula los valores SEO que se inyectan en el layout head.blade.php.
 *
 * Uso: $seo->setTitle('Mi título')->setDescription('Mi descripción')
 */
class SeoService
{
    /** @var string Título de la página */
    private string $title = '';

    /** @var string Descripción de la página */
    private string $description = '';

    /** @var string Palabras clave para meta keywords */
    private string $keywords = '';

    /** @var string URL base de la página (sin parámetros de idioma) */
    private string $url = '';

    /** @var string Tipo de contenido para Open Graph (website, article, etc.) */
    private string $type = 'website';

    /** @var string URL de la imagen para Open Graph y Twitter Cards */
    private string $image = '';

    /** @var string Directiva para meta robots (index,follow / noindex,follow...) */
    private string $robots = 'index,follow';

    /** @var string|null Nombre del autor del contenido */
    private ?string $author = null;

    /** @var string|null Fecha de publicación en formato ISO 8601 */
    private ?string $publishedAt = null;

    /** @var string|null Fecha de última modificación en formato ISO 8601 */
    private ?string $modifiedAt = null;

    /** @var array<int, array{name: string, url: string}> Migas de pan para BreadcrumbList JSON-LD */
    private array $breadcrumbs = [];

    /**
     * Establece el título de la página.
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Establece la descripción meta de la página.
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Establece las palabras clave meta de la página.
     */
    public function setKeywords(string $keywords): static
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Establece la URL base de la página.
     */
    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Establece el tipo de contenido Open Graph (website, article, product...).
     */
    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Establece la imagen para Open Graph y Twitter Cards.
     */
    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Establece la directiva meta robots para la página.
     */
    public function setRobots(string $robots): static
    {
        $this->robots = $robots;

        return $this;
    }

    /**
     * Establece el nombre del autor del contenido.
     */
    public function setAuthor(?string $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Establece la fecha de publicación en formato ISO 8601.
     */
    public function setPublishedAt(?string $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Establece la fecha de última modificación en formato ISO 8601.
     */
    public function setModifiedAt(?string $modifiedAt): static
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Define las migas de pan para generar BreadcrumbList en JSON-LD.
     *
     * @param  array<int, array{name: string, url: string}>  $breadcrumbs
     */
    public function setBreadcrumbs(array $breadcrumbs): static
    {
        $this->breadcrumbs = $breadcrumbs;

        return $this;
    }

    /**
     * Carga automáticamente los datos SEO desde un modelo que use el trait HasSeo.
     */
    public function fromModel(object $model): static
    {
        if (method_exists($model, 'getSeoTitleText')) {
            $this->title = $model->getSeoTitleText() ?: $this->title;
        }
        if (method_exists($model, 'getSeoDescriptionText')) {
            $this->description = $model->getSeoDescriptionText() ?: $this->description;
        }
        if (method_exists($model, 'getSeoKeywordsText')) {
            $this->keywords = $model->getSeoKeywordsText() ?: $this->keywords;
        }
        if (! empty($model->image)) {
            $this->image = asset('storage/'.$model->image);
        } elseif (! empty($model->featured_image)) {
            $this->image = $model->featured_image;
        }

        if (isset($model->user) && ! empty($model->user?->name)) {
            $this->author = $model->user->name;
        }

        if (! empty($model->published_at) && method_exists($model->published_at, 'toIso8601String')) {
            $this->publishedAt = $model->published_at->toIso8601String();
        }

        if (! empty($model->updated_at) && method_exists($model->updated_at, 'toIso8601String')) {
            $this->modifiedAt = $model->updated_at->toIso8601String();
        }

        return $this;
    }

    /**
     * Convierte los datos SEO a un array para pasar a la vista.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $siteTitle = (string) setting('site_title', config('app.name'));
        $baseUrl = $this->url ?: url()->current();
        $langParam = request()->query('lang');
        $canonicalUrl = ($langParam && in_array($langParam, config('locales.available', ['es', 'en']), true))
            ? $baseUrl.'?lang='.$langParam
            : $baseUrl;

        return [
            'title' => $this->title ?: $siteTitle,
            'description' => $this->description ?: (string) setting('site_description', ''),
            'keywords' => $this->keywords ?: (string) setting('default_meta_keywords', ''),
            'baseUrl' => $baseUrl,
            'url' => $canonicalUrl,
            'type' => $this->type,
            'image' => $this->image ?: asset('images/redes-sociales/social-network-1200x1200.webp'),
            'robots' => $this->robots,
            'author' => $this->author ?: $siteTitle,
            'publishedAt' => $this->publishedAt,
            'modifiedAt' => $this->modifiedAt,
            'breadcrumbs' => $this->breadcrumbs,
        ];
    }

    /**
     * Construye el grafo Schema.org JSON-LD completo para la página actual.
     *
     * @return array<string, mixed>
     */
    public function toJsonLd(): array
    {
        $data = $this->toArray();
        $siteTitle = (string) setting('site_title', config('app.name'));
        $siteUrl = url('/');
        $logoUrl = asset('images/logos/logo-180x180.png');

        $sameAs = array_values(array_filter([
            setting('facebook_url'),
            setting('twitter_url'),
            setting('instagram_url'),
            setting('linkedin_url'),
            setting('github_url'),
        ]));

        $organization = array_filter([
            '@type' => 'Organization',
            '@id' => $siteUrl.'/#organization',
            'name' => $siteTitle,
            'url' => $siteUrl,
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $logoUrl,
            ],
            'email' => setting('contact_email') ?: null,
            'telephone' => setting('contact_phone') ?: null,
            'sameAs' => ! empty($sameAs) ? $sameAs : null,
        ]);

        $graph = [$organization];

        if ($data['type'] === 'article') {
            $graph[] = array_filter([
                '@type' => 'BlogPosting',
                '@id' => $data['url'].'#article',
                'mainEntityOfPage' => [
                    '@type' => 'WebPage',
                    '@id' => $data['url'],
                ],
                'headline' => $data['title'],
                'name' => $data['title'],
                'description' => $data['description'],
                'image' => [$data['image']],
                'url' => $data['url'],
                'inLanguage' => app()->getLocale(),
                'datePublished' => $data['publishedAt'],
                'dateModified' => $data['modifiedAt'] ?? $data['publishedAt'],
                'author' => [
                    '@type' => 'Person',
                    'name' => $data['author'],
                ],
                'publisher' => [
                    '@id' => $siteUrl.'/#organization',
                ],
            ]);
        } else {
            $graph[] = array_filter([
                '@type' => 'WebSite',
                '@id' => $siteUrl.'/#website',
                'name' => $siteTitle,
                'description' => (string) setting('site_description', ''),
                'url' => $siteUrl,
                'inLanguage' => app()->getLocale(),
                'publisher' => [
                    '@id' => $siteUrl.'/#organization',
                ],
            ]);

            $graph[] = array_filter([
                '@type' => 'WebPage',
                '@id' => $data['url'].'#webpage',
                'name' => $data['title'],
                'description' => $data['description'],
                'url' => $data['url'],
                'inLanguage' => app()->getLocale(),
                'isPartOf' => [
                    '@id' => $siteUrl.'/#website',
                ],
                'datePublished' => $data['publishedAt'],
                'dateModified' => $data['modifiedAt'],
            ]);
        }

        if (! empty($this->breadcrumbs)) {
            $items = [];
            foreach ($this->breadcrumbs as $index => $crumb) {
                $items[] = [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $crumb['name'],
                    'item' => $crumb['url'],
                ];
            }

            $graph[] = [
                '@type' => 'BreadcrumbList',
                '@id' => $data['url'].'#breadcrumb',
                'itemListElement' => $items,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];
    }
}
