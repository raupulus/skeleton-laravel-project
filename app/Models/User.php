<?php

namespace App\Models;

use App\Enums\Role;
use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

/**
 * Modelo de usuario de la plataforma.
 * Soporta roles (superadmin, admin, user), autenticación API con Sanctum
 * y acceso a los paneles Filament según el rol asignado.
 *
 * @property int $id Identificador único del usuario
 * @property string $name Nombre completo
 * @property string $email Correo electrónico
 * @property Carbon|null $email_verified_at Fecha de verificación del email
 * @property string $password Hash de la contraseña
 * @property Role $role Rol asignado (SuperAdmin, Admin, User)
 * @property string|null $avatar Ruta del avatar en almacenamiento
 * @property bool $is_active Estado de activación
 * @property string|null $remember_token Token de sesión recordada
 * @property Carbon $created_at Fecha de registro
 * @property Carbon $updated_at Fecha de última modificación
 * @property Carbon|null $deleted_at Fecha de eliminación lógica
 * @property-read string|null $avatar_url URL dinámica del avatar
 * @property-read Collection<int, Page> $pages Páginas creadas
 * @property-read Collection<int, Post> $posts Posts creados
 *
 * @method static Builder<User> active() Filtra usuarios activos
 * @method static Builder<User> byRole(Role $role) Filtra usuarios por rol
 * @method static Builder<User> admins() Filtra administradores y superadministradores
 */
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /** @var array<string> Campos asignables en masa */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'avatar', 'is_active',
    ];

    /** @var array<string> Campos ocultos en la serialización JSON */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Definición de los casts de atributos del modelo.
     * Convierte tipos PHP nativos a/desde los valores de la BD.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
            'is_active' => 'boolean',
        ];
    }

    /**
     * Determina si el usuario puede acceder a un panel Filament específico.
     * El panel admin requiere rol admin o superadmin; el panel usuario requiere estar activo.
     *
     * @param  Panel  $panel  El panel Filament al que se intenta acceder
     * @return bool True si el usuario tiene acceso al panel
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->role->isAdmin() && $this->is_active;
        }

        // El panel de usuario (/panel) es accesible por cualquier usuario activo
        return $this->is_active;
    }

    // =========================================================
    // ACCESSORS
    // =========================================================

    /**
     * Devuelve la URL dinámica y pública del avatar del usuario.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar ? Storage::disk('public')->url($this->avatar) : null;
    }

    // =========================================================
    // SCOPES — Filtros reutilizables para consultas Eloquent
    // =========================================================

    /**
     * Scope para filtrar solo usuarios activos.
     *
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para filtrar usuarios por rol específico.
     *
     * @param  Builder<User>  $query
     * @param  Role  $role  El rol a filtrar
     * @return Builder<User>
     */
    public function scopeByRole(Builder $query, Role $role): Builder
    {
        return $query->where('role', $role);
    }

    /**
     * Scope para obtener solo usuarios con rol admin o superadmin.
     *
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public function scopeAdmins(Builder $query): Builder
    {
        return $query->whereIn('role', [Role::SuperAdmin->value, Role::Admin->value]);
    }

    // =========================================================
    // RELACIONES
    // =========================================================

    /**
     * Relación con las páginas creadas por este usuario.
     *
     * @return HasMany<Page>
     */
    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Relación con los posts creados por este usuario.
     *
     * @return HasMany<Post>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    // =========================================================
    // HELPERS — Métodos de ayuda para verificaciones de rol
    // =========================================================

    /**
     * Comprueba si el usuario tiene el rol de super administrador.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === Role::SuperAdmin;
    }

    /**
     * Comprueba si el usuario tiene rol de administrador (admin o superadmin).
     */
    public function isAdmin(): bool
    {
        return $this->role->isAdmin();
    }
}
