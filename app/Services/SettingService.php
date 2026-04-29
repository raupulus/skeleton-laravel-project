<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Servicio para la gestión de configuraciones de la plataforma.
 * Carga todos los settings desde la base de datos y los cachea durante 1 hora
 * para minimizar consultas repetidas a la BD.
 *
 * Uso: app(SettingService::class)->get('site_title', 'Valor por defecto')
 * O mediante el helper global: setting('site_title')
 */
class SettingService
{
    /** @var string Clave de caché donde se almacenan todos los settings */
    private const CACHE_KEY = 'settings_all';

    /** @var int Duración de la caché en segundos (1 hora) */
    private const CACHE_TTL = 3600;

    /**
     * Obtiene el valor de un setting por su clave.
     * Si el setting no existe, devuelve el valor por defecto.
     * Los settings se cargan desde caché para evitar consultas repetidas a la BD.
     *
     * @param  string  $key      La clave del setting a buscar
     * @param  mixed   $default  Valor a devolver si el setting no existe
     * @return mixed             El valor del setting o el valor por defecto
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->all();
        return $settings[$key] ?? $default;
    }

    /**
     * Devuelve todos los settings en formato array asociativo clave => valor.
     * Los datos se cargan desde la caché o desde la BD si la caché no existe.
     *
     * @return array<string, string|null>  Array con todos los settings
     */
    public function all(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function (): array {
            return Setting::all()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Limpia la caché de settings, forzando que se recarguen desde la BD.
     * Se llama automáticamente desde los Resources de Filament al guardar cambios.
     *
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
