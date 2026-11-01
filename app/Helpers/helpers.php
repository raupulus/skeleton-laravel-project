<?php

/**
 * Funciones helper globales disponibles en toda la aplicación.
 * Registradas automáticamente mediante composer.json (autoload.files).
 */

use App\Services\SettingService;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Storage;

if (! function_exists('setting')) {
    /**
     * Obtiene el valor de un setting de la plataforma por su clave.
     * Los settings se cargan desde caché (1 hora) para minimizar consultas a la BD.
     * Si el setting no existe o la BD no está disponible, devuelve el valor por defecto.
     *
     * @param  string  $key  La clave del setting (ej: 'site_title', 'contact_email')
     * @param  mixed  $default  Valor a devolver si el setting no existe
     * @return mixed El valor del setting o el valor por defecto
     */
    function setting(string $key, mixed $default = null): mixed
    {
        try {
            return app(SettingService::class)->get($key, $default);
        } catch (Throwable) {
            return $default;
        }
    }
}

if (! function_exists('media_url')) {
    /**
     * Resuelve la URL pública y dinámica de un asset o imagen almacenada en el disco público.
     *
     * @param  string|null  $path  Ruta relativa en storage/app/public
     * @return string|null URL pública completa o null si la ruta es vacía
     */
    function media_url(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }
}

if (! function_exists('storage_image')) {
    /**
     * Resuelve de forma segura y dinámica la URL pública de una imagen en el disco público.
     * Alias corporativo de media_url().
     *
     * @param  string|null  $path  Ruta relativa de la imagen en storage/app/public
     * @return string|null URL pública completa o null si la ruta es vacía
     */
    function storage_image(?string $path): ?string
    {
        return media_url($path);
    }
}

if (! function_exists('format_date')) {
    /**
     * Formatea de forma segura una fecha al formato peninsular estándar (d/m/Y).
     *
     * @param  mixed  $date  Instancia Carbon, string de fecha o timestamp
     * @param  string  $format  Formato de salida (por defecto 'd/m/Y')
     * @return string Fecha formateada o cadena vacía si es nula
     */
    function format_date(mixed $date, string $format = 'd/m/Y'): string
    {
        if (empty($date)) {
            return '';
        }

        try {
            if ($date instanceof CarbonInterface) {
                return $date->format($format);
            }

            return Carbon::parse($date)->format($format);
        } catch (Throwable) {
            return (string) $date;
        }
    }
}
