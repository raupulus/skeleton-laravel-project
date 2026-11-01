# Módulo: Enums

*Última actualización: 2026-11-01*

> Enumeraciones PHP backed que definen los valores constantes del sistema: roles de usuario, estados de contenido y estados de email.

---

## Resumen

La plataforma usa tres enums PHP 8.4 (`string`-backed) para tipado fuerte y consistencia. Cada enum incluye un método `label(): string` traducible mediante `__('filament.*')` (con claves en `lang/es/filament.php` y `lang/en/filament.php`) y métodos adicionales según su propósito.

---

## Role

**Archivo**: `app/Enums/Role.php`

Define los roles de usuario de la plataforma.

| Case | Value | Clave de traducción (`label()`) | ES / EN | `isAdmin()` |
|------|-------|---------------------------------|---------|:-----------:|
| `SuperAdmin` | `superadmin` | `filament.role_superadmin` | Super Administrador / Super Administrator | ✅ |
| `Admin` | `admin` | `filament.role_admin` | Administrador / Administrator | ✅ |
| `User` | `user` | `filament.role_user` | Usuario / User | ❌ |

**Métodos**:
- `label(): string` — Devuelve la etiqueta traducida según el locale activo
- `isAdmin(): bool` — `true` para `SuperAdmin` y `Admin`

**Cast en User**: `'role' => Role::class`

---

## ContentStatus

**Archivo**: `app/Enums/ContentStatus.php`

Define los estados posibles de posts y páginas.

| Case | Value | Clave de traducción (`label()`) | ES / EN | Color Filament |
|------|-------|---------------------------------|---------|----------------|
| `Draft` | `draft` | `filament.status_draft` | Borrador / Draft | `warning` (amarillo) |
| `Published` | `published` | `filament.status_published` | Publicado / Published | `success` (verde) |

**Métodos**:
- `label(): string` — Etiqueta traducida
- `color(): string` — Color para badges en Filament

**Cast en Post/Page**: `'status' => ContentStatus::class`

---

## EmailStatus

**Archivo**: `app/Enums/EmailStatus.php`

Define los estados de los emails enviados.

| Case | Value | Clave de traducción (`label()`) | ES / EN | Color Filament |
|------|-------|---------------------------------|---------|----------------|
| `Sent` | `sent` | `filament.email_status_sent` | Enviado / Sent | `success` (verde) |
| `Failed` | `failed` | `filament.email_status_failed` | Fallido / Failed | `danger` (rojo) |

**Métodos**:
- `label(): string` — Etiqueta traducida
- `color(): string` — Color para badges en Filament

**Cast en SentEmail**: `'status' => EmailStatus::class`
