# Módulo: Enums

*Última actualización: 2026-08-26*

> Enumeraciones PHP backed que definen los valores constantes del sistema: roles de usuario, estados de contenido y estados de email.

---

## Resumen

La plataforma usa tres enums PHP 8.1+ (backed string) para tipado fuerte y consistencia. Cada enum incluye métodos `label()` (etiqueta legible en español) y métodos adicionales según su propósito.

---

## Role

**Archivo**: `app/Enums/Role.php`

Define los roles de usuario de la plataforma.

| Case | Value | Label | `isAdmin()` |
|------|-------|-------|:-----------:|
| `SuperAdmin` | `superadmin` | Super Administrador | ✅ |
| `Admin` | `admin` | Administrador | ✅ |
| `User` | `user` | Usuario | ❌ |

**Métodos**:
- `label(): string` — Devuelve el nombre legible en español
- `isAdmin(): bool` — `true` para SuperAdmin y Admin

**Cast en User**: `'role' => Role::class`

---

## ContentStatus

**Archivo**: `app/Enums/ContentStatus.php`

Define los estados posibles de posts y páginas.

| Case | Value | Label | Color Filament |
|------|-------|-------|----------------|
| `Draft` | `draft` | Borrador | `warning` (amarillo) |
| `Published` | `published` | Publicado | `success` (verde) |

**Métodos**:
- `label(): string` — Etiqueta en español
- `color(): string` — Color para badges en Filament

**Cast en Post/Page**: `'status' => ContentStatus::class`

---

## EmailStatus

**Archivo**: `app/Enums/EmailStatus.php`

Define los estados de los emails enviados.

| Case | Value | Label | Color Filament |
|------|-------|-------|----------------|
| `Sent` | `sent` | Enviado | `success` (verde) |
| `Failed` | `failed` | Fallido | `danger` (rojo) |

**Métodos**:
- `label(): string` — Etiqueta en español
- `color(): string` — Color para badges en Filament

**Cast en SentEmail**: `'status' => EmailStatus::class`
