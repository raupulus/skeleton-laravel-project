<?php

/**
 * Funciones helper globales disponibles en toda la aplicación.
 * Registradas automáticamente mediante composer.json (autoload.files).
 */

use App\Services\SettingService;

if (!function_exists('setting')) {
    /**
     * Obtiene el valor de un setting de la plataforma por su clave.
     * Los settings se cargan desde caché (1 hora) para minimizar consultas a la BD.
     * Si el setting no existe, devuelve el valor por defecto proporcionado.
     *
     * @param  string  $key      La clave del setting (ej: 'site_title', 'contact_email')
     * @param  mixed   $default  Valor a devolver si el setting no existe
     * @return mixed             El valor del setting o el valor por defecto
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return app(SettingService::class)->get($key, $default);
    }
}
