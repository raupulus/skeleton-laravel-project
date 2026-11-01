# Módulo: Usuarios

*Última actualización: 2026-11-01*

> Gestión de cuentas de usuario con sistema de roles, autenticación web y API, y control de acceso a los paneles Filament.

---

## Objetivo y funcionalidad

El módulo de usuarios proporciona toda la infraestructura de gestión de identidad y acceso de la plataforma. Su objetivo es permitir que existan distintos perfiles de usuario con niveles de acceso diferenciados:

- **Superadmin**: control total del sistema, acceso al panel de administración (`/admin`) con permisos completos sobre todos los recursos.
- **Admin**: acceso al panel de administración con los mismos permisos de gestión de contenido, pero sin capacidad para modificar ni asignar el rol `superadmin`.
- **User**: acceso únicamente al panel de usuario (`/panel`), donde puede gestionar su perfil personal y sus tokens de API.

El módulo incluye autenticación web con sesiones HTTP (registro, login, recuperación y confirmación de contraseña) y autenticación API con Laravel Sanctum (generación de tokens Bearer para consumo externo). Cada usuario puede tener un avatar, un estado activo/inactivo que controla el acceso a toda la plataforma, y se implementa borrado lógico (soft delete) para no perder datos históricos.

Desde el panel admin, los administradores pueden crear, editar, desactivar y eliminar usuarios. Los usuarios normales solo pueden editar su propio perfil desde el panel de usuario (`/panel`). Las policies de autorización garantizan que un usuario no pueda eliminarse a sí mismo ni que un `admin` pueda alterar cuentas `superadmin`.

---

## Resumen

El módulo de usuarios es el pilar central de la plataforma. Define tres roles con distintos niveles de acceso (`superadmin`, `admin`, `user`), soporta autenticación web por sesión y autenticación API con Laravel Sanctum. Los usuarios pueden tener avatar (`$user->avatar_url`), estado activo/inactivo y se eliminan con borrado lógico (soft delete).

---

## Archivos principales

| Tipo | Ruta |
|------|------|
| Modelo | `app/Models/User.php` |
| Enum de roles | `app/Enums/Role.php` |
| Policy | `app/Policies/UserPolicy.php` |
| Filament Resource | `app/Filament/Admin/Resources/UserResource.php` |
| Filament Panel - Perfil | `app/Filament/Panel/Pages/EditProfile.php` |
| Filament Panel - Tokens | `app/Filament/Panel/Pages/ApiTokens.php` |
| Migración | `database/migrations/*_create_users_table.php` |
| Seeder | `database/seeders/UserSeeder.php` |
| Factory | `database/factories/UserFactory.php` |

---

## Campos del modelo

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | int (PK) | Identificador único autoincremental |
| `name` | string | Nombre completo del usuario |
| `email` | string (unique) | Dirección de email, se usa como identificador de login |
| `password` | string (hashed) | Contraseña encriptada automáticamente vía cast `hashed` |
| `role` | enum (Role) | Rol del usuario: `superadmin`, `admin` o `user` |
| `avatar` | string (nullable) | Ruta del archivo de imagen del avatar, almacenado en `storage/app/public/avatars` |
| `is_active` | boolean | Si la cuenta está activa, controla acceso a toda la plataforma |
| `email_verified_at` | datetime (nullable) | Timestamp de verificación del email |
| `remember_token` | string (nullable) | Token para la funcionalidad "recordarme" |
| `created_at` | datetime | Fecha de creación |
| `updated_at` | datetime | Fecha de última actualización |
| `deleted_at` | datetime (nullable) | Fecha de borrado lógico (soft delete) |

---

## Roles (Enum `App\Enums\Role`)

| Valor | Label | Acceso admin | Acceso panel usuario |
|-------|-------|:---:|:---:|
| `superadmin` | Super Administrador | ✅ | ✅ |
| `admin` | Administrador | ✅ | ✅ |
| `user` | Usuario | ❌ | ✅ |

El método `isAdmin()` del enum devuelve `true` para `superadmin` y `admin`.

---

## Relaciones

| Relación | Tipo | Modelo relacionado | Descripción |
|----------|------|-------------------|-------------|
| `pages()` | hasMany | Page | Páginas creadas por el usuario |
| `posts()` | hasMany | Post | Posts creados por el usuario |
| `tokens()` | hasMany (Sanctum) | PersonalAccessToken | Tokens API del usuario |

---

## Scopes

| Scope | Descripción | Ejemplo |
|-------|-------------|---------|
| `active()` | Solo usuarios activos | `User::active()->get()` |
| `byRole($role)` | Filtrar por rol específico | `User::byRole(Role::Admin)->get()` |
| `admins()` | Solo superadmin y admin | `User::admins()->get()` |

---

## Métodos helper y Accessors

| Método / Accessor | Retorno | Descripción |
|--------|---------|-------------|
| `isSuperAdmin()` | `bool` | Si el rol es `superadmin` |
| `isAdmin()` | `bool` | Si el rol es `superadmin` o `admin` |
| `canAccessPanel(Panel)` | `bool` | Evalúa acceso al panel Filament según rol e `is_active` |
| `$user->avatar_url` | `?string` | Accessor `getAvatarUrlAttribute()`: URL pública dinámica del avatar vía `Storage::disk('public')->url($this->avatar)` |

---

## Traits utilizados

- `HasApiTokens` — Sanctum: generación y gestión de tokens API personales
- `HasFactory` — Factories para tests y seeders (estados `superadmin()`, `admin()`, `inactive()`, `unverified()`)
- `Notifiable` — Envío de notificaciones por email
- `SoftDeletes` — Borrado lógico: no se eliminan de la BD, se marca `deleted_at`

---

## Control de acceso (`UserPolicy` y `UserResource`)

| Acción | Quién puede | Notas |
|--------|-------------|-------|
| Ver listado / detalle | `admin` / `superadmin` | — |
| Crear | `admin` / `superadmin` | Un `admin` no ve la opción de rol `superadmin` en el selector |
| Editar / Restaurar | `admin` / `superadmin` | Las cuentas con rol `superadmin` solo pueden ser editadas o restauradas por otro `superadmin` |
| Eliminar / ForceDelete | Solo `superadmin` | Nunca puede eliminarse a sí mismo (`$user->id !== $model->id`) |

En `UserResource` y `EditProfile`, el campo `avatar` utiliza `ImageCropField::make4x3('avatar', 'avatars')`.

---

## Datos de ejemplo (Seeder)

El `UserSeeder` crea:
- `admin@example.com` con rol `superadmin` y contraseña `password`
- `editor@example.com` con rol `admin` y contraseña `password`
- 10 usuarios adicionales con rol `user`

Es idempotente (usa `firstOrCreate`).
