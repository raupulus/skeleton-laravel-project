<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

/**
 * Controlador para el cambio de idioma del sitio web.
 * Persiste el idioma seleccionado en la sesión del usuario.
 */
class LanguageController extends Controller
{
    /**
     * Cambia el idioma activo de la aplicación y redirige a la página anterior.
     * Solo acepta idiomas que estén en la lista de idiomas disponibles.
     *
     * @param  string  $locale  El código del idioma a establecer (ej: 'es', 'en')
     * @return RedirectResponse Redirección a la página de origen
     */
    public function switch(string $locale): RedirectResponse
    {
        // Validar que el idioma solicitado est disponible en la aplicacin
        if (in_array($locale, config('locales.available', ['es', 'en']))) {
            session()->put('locale', $locale);
            app()->setLocale($locale);
        }

        return redirect()->back()->withHeaders(['Content-Language' => app()->getLocale()]);
    }
}
