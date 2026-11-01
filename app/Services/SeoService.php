<?php

namespace App\Services;

use App\Traits\HasSeo;

/**
 * Servicio para la gestión dinámica de meta tags SEO.
 * Acumula los valores SEO que se inyectan en el layout head.blade.php.
 * Se puede instanciar desde los controladores para configurar el SEO de cada página.
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

    /** @var string URL canónica de la página */
    private string $url = '';

    /** @var string Tipo de contenido para Open Graph (website, article, etc.) */
    private string $type = 'website';

    /** @var string URL de la imagen para Open Graph y Twitter Cards */
    private string $image = '';

    /** @var string Directiva para meta robots (index,follow / noindex,follow...) */
    private string $robots = 'index,follow';

    /** @var string|null Nombre del autor del contenido */
    private ?string $author = null;

    /** @var string|null Fecha de publicación para artículos */
    private ?string $publishedAt = null;

    /**
     * Establece el título de la página.
     *
     * @param  string  $title  El título a mostrar en la etiqueta <title> y meta OG
     * @return static Instancia actual para encadenamiento de métodos
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Establece la descripción meta de la página.
     *
     * @param  string  $description  La descripción para meta description y OG description
     * @return static Instancia actual para encadenamiento
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Establece las palabras clave meta de la página.
     *
     * @param  string  $keywords  Las keywords separadas por comas
     * @return static Instancia actual para encadenamiento
     */
    public function setKeywords(string $keywords): static
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Establece la URL canónica de la página.
     *
     * @param  string  $url  La URL canónica completa
     * @return static Instancia actual para encadenamiento
     */
    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Establece el tipo de contenido Open Graph (website, article, product...).
     *
     * @param  string  $type  El tipo de contenido OG
     * @return static Instancia actual para encadenamiento
     */
    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Establece la imagen para Open Graph y Twitter Cards.
     *
     * @param  string  $image  URL completa de la imagen
     * @return static Instancia actual para encadenamiento
     */
    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Establece la directiva meta robots para la página.
     *
     * @param  string  $robots  La directiva (ej: 'noindex,follow', 'noindex,nofollow')
     * @return static Instancia actual para encadenamiento
     */
    public function setRobots(string $robots): static
    {
        $this->robots = $robots;

        return $this;
    }

    /**
     * Carga automáticamente los datos SEO desde un modelo que use el trait HasSeo.
     * Útil para páginas de detalle de posts y páginas dinámicas.
     *
     * @param  object  $model  El modelo con el trait HasSeo
     * @return static Instancia actual para encadenamiento
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
        if (isset($model->image) && $model->image) {
            $this->image = asset('storage/'.$model->image);
        }

        return $this;
    }

    /**
     * Convierte los datos SEO a un array para pasar a la vista.
     *
     * @return array<string, string|null> Array con todos los datos SEO
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title ?: setting('site_title', config('app.name')),
            'description' => $this->description ?: setting('site_description', ''),
            'keywords' => $this->keywords ?: setting('default_meta_keywords', ''),
            'url' => $this->url ?: url()->current(),
            'type' => $this->type,
            'image' => $this->image ?: asset('images/redes-sociales/social-network-1200x1200.webp'),
            'robots' => $this->robots,
            'author' => $this->author,
            'publishedAt' => $this->publishedAt,
        ];
    }
}
