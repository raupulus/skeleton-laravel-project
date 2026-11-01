<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * Trait para eliminar físicamente del disco 'public' los archivos de imagen o avatar
 * asociados a un modelo cuando son reemplazados o cuando el registro se elimina definitivamente.
 */
trait CleansUpStorageFiles
{
    /**
     * Registra los eventos del ciclo de vida del modelo para limpiar archivos huérfanos.
     */
    public static function bootCleansUpStorageFiles(): void
    {
        static::updating(function ($model): void {
            foreach ($model->storageFileAttributes() as $attribute) {
                if ($model->isDirty($attribute)) {
                    $original = $model->getOriginal($attribute);
                    if (! empty($original) && is_string($original)) {
                        Storage::disk('public')->delete($original);
                    }
                }
            }
        });

        $deleteFiles = function ($model): void {
            foreach ($model->storageFileAttributes() as $attribute) {
                $path = $model->getAttribute($attribute);
                if (! empty($path) && is_string($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        };

        if (in_array(SoftDeletes::class, class_uses_recursive(static::class), true)) {
            static::forceDeleted($deleteFiles);
        } else {
            static::deleted($deleteFiles);
        }
    }

    /**
     * Atributos del modelo que almacenan rutas de archivo en Storage::disk('public').
     *
     * @return array<int, string>
     */
    protected function storageFileAttributes(): array
    {
        return property_exists($this, 'storageAttributes')
            ? $this->storageAttributes
            : ['image'];
    }
}
