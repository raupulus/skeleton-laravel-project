# Módulo: Usuarios

> Gestión de cuentas de usuario con sistema de roles, autenticación web y API, y control de acceso a los paneles Filament.

---

## Resumen

El módulo de usuarios es el pilar central de la plataforma. Define tres roles con distintos niveles de acceso (`superadmin`, `admin`, `user`), soporta autenticación web mediante Laravel Breeze y autenticación API con Laravel Sanctum. Los usuarios pueden tener avatar, estado activo/inactivo y se eliminan con borrado lógico (soft delete).

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

## Métodos helper

| Método | Retorno | Descripción |
|--------|---------|-------------|
| `isSuperAdmin()` | bool | Si el rol es `superadmin` |
| `isAdmin()` | bool | Si el rol es `superadmin` o `admin` |
| `canAccessPanel(Panel)` | bool | Evalúa acceso al panel Filament según rol e `is_active` |

---

## Traits utilizados

- `HasApiTokens` — Sanctum: generación y gestión de tokens API personales
- `HasFactory` — Factories para tests y seeders
- `Notifiable` — Envío de notificaciones por email
- `SoftDeletes` — Borrado lógico: no se eliminan de la BD, se marca `deleted_at`

---

## Control de acceso (Policy)

La `UserPolicy` restringe la gestión de usuarios:

| Acción | Quién puede | Notas |
|--------|-------------|-------|
| Ver listado | admin/superadmin | — |
| Ver detalle | admin/superadmin o el propio usuario | — |
| Crear | admin/superadmin | — |
| Editar | admin/superadmin o el propio usuario | — |
| Eliminar | admin/superadmin | No puede eliminarse a sí mismo |

---

## Datos de ejemplo (Seeder)

El `UserSeeder` crea:
- `admin@example.com` con rol `superadmin` y contraseña `password`
- `editor@example.com` con rol `admin` y contraseña `password`
- 10 usuarios adicionales con rol `user`

Es idempotente (usa `firstOrCreate`).
