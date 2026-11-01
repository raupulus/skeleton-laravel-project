<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de configuración de la plataforma (patrón key-value).
 * Permite gestionar toda la configuración del sitio desde el backend Filament.
 * Se accede a los valores mediante el helper global setting('key').
 *
 * @property int $id Identificador único
 * @property string $key Clave única de la configuración
 * @property string $display_name Nombre legible para mostrar en el backend
 * @property string|null $value Valor de la configuración
 * @property string|null $details Descripción/ayuda del uso de este setting
 * @property string $type Tipo de dato: text, textarea, image, select, etc.
 * @property int $order Orden de visualización dentro del grupo
 * @property string $group Grupo al que pertenece (general, seo, social, contact)
 * @property Carbon $created_at Fecha de creación
 * @property Carbon $updated_at Fecha de actualización
 *
 * @method static Builder<Setting> byGroup(string $group) Filtra settings por grupo ordenados
 */
class Setting extends Model
{
    use HasFactory;

    /** @var array<string> Campos asignables en masa */
    protected $fillable = ['key', 'display_name', 'value', 'details', 'type', 'order', 'group'];

    /**
     * Definición de casts de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['order' => 'integer'];
    }

    // =========================================================
    // SCOPES
    // =========================================================

    /**
     * Scope para filtrar settings por grupo.
     *
     * @param  Builder<Setting>  $query
     * @param  string  $group  El grupo a filtrar
     * @return Builder<Setting>
     */
    public function scopeByGroup(Builder $query, string $group): Builder
    {
        return $query->where('group', $group)->orderBy('order');
    }
}
