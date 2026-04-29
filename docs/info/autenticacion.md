# Módulo: Autenticación y Autorización

> Autenticación web con Laravel Breeze, autenticación API con Laravel Sanctum, policies de autorización por modelo, middleware de idioma y guards de Filament.

---

## Resumen

La plataforma ofrece dos sistemas de autenticación paralelos: autenticación web (formularios HTML con sesiones, provista por Laravel Breeze) y autenticación API (tokens Bearer, provista por Laravel Sanctum). La autorización se gestiona mediante Policies que restringen el acceso por modelo y mediante el método `canAccessPanel()` del modelo User para los paneles Filament.

---

## Autenticación Web (Breeze)

### Vistas

Ubicadas en `resources/views/auth/`:
- `login.blade.php` — Inicio de sesión
- `register.blade.php` — Registro de cuenta
- `forgot-password.blade.php` — Solicitar enlace de restablecimiento
- `reset-password.blade.php` — Restablecer contraseña
- `verify-email.blade.php` — Verificación de email
- `confirm-password.blade.php` — Confirmar contraseña

### Rutas

Registradas en `routes/auth.php`, incluido desde `routes/web.php`.

---

## Autenticación API (Sanctum)

### Controlador

`app/Http/Controllers/Api/V1/AuthController.php`

### Endpoints

| Método | URI | Nombre | Auth | Descripción |
|--------|-----|--------|:---:|-------------|
| POST | `/api/v1/auth/register` | `api.v1.auth.register` | ❌ | Registra usuario y devuelve token |
| POST | `/api/v1/auth/login` | `api.v1.auth.login` | ❌ | Login y devuelve token |
| POST | `/api/v1/auth/forgot-password` | `api.v1.auth.forgot-password` | ❌ | Envía enlace de reset |
| POST | `/api/v1/auth/reset-password` | `api.v1.auth.reset-password` | ❌ | Resetea la contraseña |
| GET | `/api/v1/auth/user` | `api.v1.auth.user` | ✅ | Datos del usuario autenticado |
| POST | `/api/v1/auth/logout` | `api.v1.auth.logout` | ✅ | Revoca el token actual |

### Tokens API (gestión)

Controlador: `app/Http/Controllers/Api/V1/TokenController.php`

| Método | URI | Nombre | Descripción |
|--------|-----|--------|-------------|
| GET | `/api/v1/user/tokens` | `api.v1.tokens.index` | Listar tokens del usuario |
| POST | `/api/v1/user/tokens` | `api.v1.tokens.store` | Crear nuevo token |
| DELETE | `/api/v1/user/tokens/{id}` | `api.v1.tokens.destroy` | Eliminar token |

---

## Policies

Todas las policies están registradas en `app/Providers/AppServiceProvider.php` vía `Gate::policy()`.

| Policy | Modelo | Quién puede gestionar |
|--------|--------|----------------------|
| `UserPolicy` | User | admin/superadmin (eliminar: no a sí mismo) |
| `PostPolicy` | Post | admin/superadmin |
| `PagePolicy` | Page | admin/superadmin |
| `CategoryPolicy` | Category | admin/superadmin |
| `SlidePolicy` | Slide | admin/superadmin |
| `SectionPolicy` | Section | admin/superadmin |
| `SettingPolicy` | Setting | admin/superadmin |
| `SentEmailPolicy` | SentEmail | admin/superadmin (solo lectura) |

---

## Middleware SetLocale

Archivo: `app/Http/Middleware/SetLocale.php`

Registrado globalmente en `bootstrap/app.php`. Establece el idioma de la aplicación en cada request:

1. **Prioridad 1**: Valor guardado en `session('locale')`
2. **Prioridad 2**: Cabecera `Accept-Language` del navegador
3. **Fallback**: `config('app.locale')` (español)

---

## Guards de Filament

El control de acceso a paneles Filament se gestiona en `User::canAccessPanel(Panel)`:

- **Panel Admin** (`/admin`): Requiere `role->isAdmin()` (superadmin o admin) Y `is_active = true`
- **Panel Usuario** (`/panel`): Requiere solo `is_active = true` (cualquier rol)

No se necesitan guards adicionales.

---

## FormRequests

Ubicados en `app/Http/Requests/`. Cada formulario tiene su propio FormRequest con validación y mensajes en español:
- `Web/ContactRequest.php` — Formulario de contacto
- `Api/V1/Auth/LoginRequest.php` — Login API
- `Api/V1/Auth/RegisterRequest.php` — Registro API
- `Api/V1/Auth/ForgotPasswordRequest.php` — Solicitar reset
- `Api/V1/Auth/ResetPasswordRequest.php` — Resetear contraseña
