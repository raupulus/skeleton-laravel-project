<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * Trait para la generación automática de slug único a partir del título del modelo.
 * Se ejecuta automáticamente en el evento 'creating' del modelo Eloquent.
 * Soporta modelos con SoftDeletes para evitar duplicados con registros eliminados.
 */
trait HasSlug
{
    /**
     * Hook de arranque del trait, registra el listener del evento 'creating'.
     *
     * @return void
     */
    public static function bootHasSlug(): void
    {
        static::creating(function ($model): void {
            // Solo generar slug si no se proporcionó uno explícitamente
            if (empty($model->slug)) {
                $source = $model->getSlugSource();

                // Soporte para campos traducibles: obtener el valor del idioma actual
                $value = is_array($source)
                    ? ($source[config('app.locale')] ?? $source[config('app.fallback_locale')] ?? reset($source) ?: '')
                    : ($source ?? '');

                $model->slug = $model->generateUniqueSlug(Str::slug($value));
            }
        });
    }

    /**
     * Define el campo fuente para generar el slug.
     * Por defecto usa el campo 'title'. Sobreescribir en el modelo si es necesario.
     *
     * @return mixed  El valor del campo o array de traducciones
     */
    protected function getSlugSource(): mixed
    {
        return $this->title;
    }

    /**
     * Genera un slug único asegurándose de que no existe en la BD.
     * Si el slug ya existe, añade un sufijo numérico incremental (-1, -2, etc.).
     *
     * @param  string  $slug  El slug base generado a partir del título
     * @return string         El slug único garantizado
     */
    protected function generateUniqueSlug(string $slug): string
    {
        $original = $slug;
        $count = 1;

        // Incluir registros soft-deleted en la verificación de unicidad
        $query = method_exists(static::class, 'withTrashed')
            ? static::withTrashed()
            : static::query();

        while ((clone $query)->where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }
}
