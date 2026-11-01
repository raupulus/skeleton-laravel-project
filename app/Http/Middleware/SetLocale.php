<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware que establece el idioma de la aplicación según la sesión del usuario
 * o la cabecera Accept-Language del navegador. El idioma por defecto es español.
 */
class SetLocale
{
    /**
     * Maneja la petición entrante estableciendo el locale de la aplicación.
     *
     * @param  Request  $request  La petición HTTP entrante
     * @param  Closure  $next  El siguiente middleware en la cadena
     * @return Response La respuesta HTTP
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener los idiomas disponibles desde la configuración
        $available = config('locales.available', ['es', 'en']);

        // 1. Parámetro explícito ?lang=xx (usado en alternates hreflang y enlaces directos)
        $queryLocale = $request->query('lang');
        if (is_string($queryLocale) && in_array($queryLocale, $available, true)) {
            $locale = $queryLocale;
            session(['locale' => $locale]);
        } else {
            // 2. Idioma guardado en sesión
            $locale = session('locale');

            // 3. Si no hay idioma en sesión, detectar desde Accept-Language del navegador
            if (! $locale && $request->hasHeader('Accept-Language')) {
                $preferred = substr((string) $request->header('Accept-Language'), 0, 2);
                if (in_array($preferred, $available, true)) {
                    $locale = $preferred;
                }
            }
        }

        // Usar el idioma detectado o el idioma por defecto de la aplicación
        $locale = is_string($locale) && in_array($locale, $available, true) ? $locale : config('app.locale', 'es');
        app()->setLocale($locale);

        return $next($request);
    }
}
