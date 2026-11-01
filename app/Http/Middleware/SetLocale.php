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

        // Intentar recuperar el idioma guardado en sesión
        $locale = session('locale');

        // Si no hay idioma en sesión, detectar desde Accept-Language del navegador
        if (! $locale && $request->hasHeader('Accept-Language')) {
            $preferred = substr($request->header('Accept-Language'), 0, 2);
            if (in_array($preferred, $available)) {
                $locale = $preferred;
            }
        }

        // Usar el idioma detectado o el idioma por defecto de la aplicación
        $locale = $locale && in_array($locale, $available) ? $locale : config('app.locale', 'es');
        app()->setLocale($locale);

        return $next($request);
    }
}
