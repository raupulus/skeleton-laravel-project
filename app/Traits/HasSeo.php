<?php

namespace App\Traits;

/**
 * Trait para gestionar campos SEO en modelos de contenido.
 * Proporciona métodos helper que obtienen el valor SEO del idioma actual
 * con fallbacks jerárquicos: SEO field → title/excerpt → string vacío.
 */
trait HasSeo
{
    /**
     * Obtiene el título SEO optimizado para el idioma actual.
     * Prioridad: seo_title → title → string vacío.
     *
     * @return string  El título SEO o el título del modelo como fallback
     */
    public function getSeoTitleText(): string
    {
        $seoTitle = $this->seo_title;

        // Si es array de traducciones, obtener el idioma actual
        if (is_array($seoTitle)) {
            $seoTitle = $seoTitle[app()->getLocale()] ?? $seoTitle[config('app.fallback_locale')] ?? '';
        }

        // Si el seo_title está vacío, usar el título del modelo
        if (!empty($seoTitle)) {
            return $seoTitle;
        }

        $title = $this->title;
        if (is_array($title)) {
            return $title[app()->getLocale()] ?? $title[config('app.fallback_locale')] ?? '';
        }

        return $title ?? '';
    }

    /**
     * Obtiene la descripción SEO optimizada para el idioma actual.
     * Prioridad: seo_description → excerpt → string vacío.
     *
     * @return string  La descripción SEO o el extracto del modelo como fallback
     */
    public function getSeoDescriptionText(): string
    {
        $seoDesc = $this->seo_description;

        if (is_array($seoDesc)) {
            $seoDesc = $seoDesc[app()->getLocale()] ?? $seoDesc[config('app.fallback_locale')] ?? '';
        }

        if (!empty($seoDesc)) {
            return $seoDesc;
        }

        // Fallback al excerpt si existe en el modelo
        if (isset($this->excerpt)) {
            $excerpt = $this->excerpt;
            if (is_array($excerpt)) {
                return $excerpt[app()->getLocale()] ?? $excerpt[config('app.fallback_locale')] ?? '';
            }
            return $excerpt ?? '';
        }

        return '';
    }

    /**
     * Obtiene las keywords SEO para el idioma actual.
     * Devuelve string vacío si no hay keywords definidas.
     *
     * @return string  Las keywords SEO o string vacío
     */
    public function getSeoKeywordsText(): string
    {
        $keywords = $this->seo_keywords;

        if (is_array($keywords)) {
            return $keywords[app()->getLocale()] ?? $keywords[config('app.fallback_locale')] ?? '';
        }

        return $keywords ?? '';
    }
}
