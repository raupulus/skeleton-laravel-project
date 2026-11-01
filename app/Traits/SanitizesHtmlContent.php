<?php

namespace App\Traits;

/**
 * Trait para sanear en servidor el contenido HTML enriquecido (RichEditor)
 * antes de persistirlo en columnas JSONB traducibles.
 */
trait SanitizesHtmlContent
{
    /**
     * Registra el evento saving para limpiar etiquetas y atributos peligrosos (XSS).
     */
    public static function bootSanitizesHtmlContent(): void
    {
        static::saving(function ($model): void {
            if (! method_exists($model, 'getTranslations')) {
                return;
            }

            foreach (['content'] as $field) {
                $translations = $model->getTranslations($field);
                if (empty($translations)) {
                    continue;
                }

                $sanitized = [];
                foreach ($translations as $locale => $html) {
                    $sanitized[$locale] = is_string($html)
                        ? static::sanitizeHtmlString($html)
                        : $html;
                }

                $model->setTranslations($field, $sanitized);
            }
        });
    }

    /**
     * Elimina etiquetas ejecutables (<script>, <iframe>, <object>, <embed>, <style>)
     * y atributos de eventos inline (on*) o esquemas javascript:/data:.
     */
    public static function sanitizeHtmlString(string $html): string
    {
        // Eliminar bloques completos de etiquetas peligrosas
        $clean = preg_replace(
            '#<(script|iframe|object|embed|applet|meta|link|style|form)\b[^>]*>.*?</\1>#is',
            '',
            $html
        ) ?? $html;

        // Eliminar etiquetas peligrosas huérfanas o auto-cerradas
        $clean = preg_replace(
            '#</?(script|iframe|object|embed|applet|meta|link|style|form|input|button)\b[^>]*>#is',
            '',
            $clean
        ) ?? $clean;

        // Eliminar manejadores de eventos inline (onload, onerror, onclick, etc.)
        $clean = preg_replace(
            '#\s+on[a-z]+\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s>]+)#i',
            '',
            $clean
        ) ?? $clean;

        // Neutralizar protocolos javascript: o vbscript: en href/src
        $clean = preg_replace(
            '#(\b(?:href|src|action)\s*=\s*["\']?)\s*(?:javascript|vbscript|data\s*:\s*text/html)\s*:[^"\'\s>]*#i',
            '$1#',
            $clean
        ) ?? $clean;

        return $clean;
    }
}
