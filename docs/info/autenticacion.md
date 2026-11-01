# Módulo: Autenticación y Autorización

*Última actualización: 2026-11-01*

> Autenticación web con sesiones, autenticación API con Laravel Sanctum, protección Google reCAPTCHA v3 y rate limiting, policies de autorización por modelo, middlewares globales (`SetLocale`, `SecurityHeaders`) y guards de Filament.

---

## Objetivo y funcionalidad

El módulo de autenticación y autorización proporciona toda la infraestructura de seguridad y control de acceso de la plataforma:

1. **Autenticación web**: formularios HTML con sesiones (`routes/auth.php`) para el acceso de usuarios al frontend y a los paneles Filament. Incluye registro, login (exigiendo `is_active = true`), recuperación y restablecimiento de contraseña, verificación de email y confirmación de contraseña.
2. **Autenticación API** (Laravel Sanctum): tokens Bearer personales para que aplicaciones externas consuman la API REST (`/api/v1`). Incluye registro, login, logout, recuperación de contraseña y gestión de tokens personales (crear, listar, revocar).
3. **Protección de formularios públicos**: todos los POST públicos aplican rate limiting (`throttle:10,1` en web) y validación invisible con Google reCAPTCHA v3 (`App\Rules\Recaptcha` + `<x-recaptcha-script>`).
4. **Autorización mediante Policies**: restringe por modelo y rol qué acciones están permitidas, protegiendo las cuentas `superadmin` frente a modificaciones de administradores regulares.

---

## Autenticación Web

### Vistas (`resources/views/auth/`)
- `login.blade.php` — Inicio de sesión (`<x-recaptcha-script action="login" />`)
- `register.blade.php` — Registro de cuenta (`<x-recaptcha-script action="register" />`)
- `forgot-password.blade.php` — Solicitar enlace de restablecimiento (`<x-recaptcha-script action="forgot_password" />`)
- `reset-password.blade.php` — Restablecer contraseña (`<x-recaptcha-script action="reset_password" />`)
- `verify-email.blade.php` — Verificación de email
- `confirm-password.blade.php` — Confirmar contraseña

### Rutas (`routes/auth.php`)

| Método | URI | Nombre | Middleware |
|--------|-----|--------|------------|
| GET | `/register` | `register` | `guest` |
| POST | `/register` | — | `guest`, `throttle:10,1` |
| GET | `/login` | `login` | `guest` |
| POST | `/login` | — | `guest`, `throttle:10,1` |
| GET | `/forgot-password` | `password.request` | `guest` |
| POST | `/forgot-password` | `password.email` | `guest`, `throttle:10,1` |
| GET | `/reset-password/{token}` | `password.reset` | `guest` |
| POST | `/reset-password` | `password.store` | `guest`, `throttle:10,1` |
| GET | `/verify-email` | `verification.notice` | `auth` |
| GET | `/verify-email/{id}/{hash}` | `verification.verify` | `auth`, `signed`, `throttle:6,1` |
| POST | `/email/verification-notification` | `verification.send` | `auth`, `throttle:6,1` |
| GET | `/confirm-password` | `password.confirm` | `auth` |
| POST | `/confirm-password` | — | `auth` |
| PUT | `/password` | `password.update` | `auth` |
| POST | `/logout` | `logout` | `auth` |

---

## Protección Google reCAPTCHA v3

- **Regla**: `App\Rules\Recaptcha` (`app/Rules/Recaptcha.php`).
  - Es una regla **implícita** (`public bool $implicit = true`): Laravel la ejecuta incluso si el campo `g-recaptcha-response` se omite o llega vacío en el POST.
  - **Omisión condicional**: si `RECAPTCHA_SITE_KEY` o `RECAPTCHA_SECRET_KEY` (`config('services.recaptcha.*')`) están vacías, la regla aprueba automáticamente para permitir desarrollo local y ejecución de tests sin llamadas externas.
  - Verifica contra `https://www.google.com/recaptcha/api/siteverify` que `success === true`, que `score >= config('services.recaptcha.min_score', 0.5)` (`RECAPTCHA_MIN_SCORE`) y que `action` coincida con la acción esperada (`contact`, `login`, `register`, `forgot_password`, `reset_password`).
- **Componente Blade**: `<x-recaptcha-script action="..." />` (`resources/views/components/recaptcha-script.blade.php`).
  - Solo renderiza el `<input type="hidden" name="g-recaptcha-response">` y el script de Google cuando ambas claves están configuradas.
  - Solicita el token justo en el evento `submit` del formulario (los tokens v3 caducan a los 2 minutos).

---

## Autenticación API (Sanctum)

### Controlador: `app/Http/Controllers/Api/V1/AuthController.php`

| Método | URI | Nombre | Auth | Throttle | Descripción |
|--------|-----|--------|:---:|----------|-------------|
| POST | `/api/v1/auth/register` | `api.v1.auth.register` | ❌ | `throttle:5,1` | Registra usuario y devuelve token |
| POST | `/api/v1/auth/login` | `api.v1.auth.login` | ❌ | `throttle:10,1` | Login (exige `is_active`) y devuelve token |
| POST | `/api/v1/auth/forgot-password` | `api.v1.auth.forgot-password` | ❌ | `throttle:3,1` | Envía enlace de reset |
| POST | `/api/v1/auth/reset-password` | `api.v1.auth.reset-password` | ❌ | `throttle:5,1` | Resetea la contraseña |
| GET | `/api/v1/auth/user` | `api.v1.auth.user` | ✅ | — | Datos del usuario autenticado (`UserResource`) |
| POST | `/api/v1/auth/logout` | `api.v1.auth.logout` | ✅ | — | Revoca el token actual |

### Gestión de Tokens API (`app/Http/Controllers/Api/V1/TokenController.php`)

| Método | URI | Nombre | Descripción |
|--------|-----|--------|-------------|
| GET | `/api/v1/user/tokens` | `api.v1.tokens.index` | Listar tokens del usuario |
| POST | `/api/v1/user/tokens` | `api.v1.tokens.store` | Crear nuevo token |
| DELETE | `/api/v1/user/tokens/{id}` | `api.v1.tokens.destroy` | Eliminar token |

---

## Policies

Registradas en `app/Providers/AppServiceProvider.php` vía `Gate::policy()`:

| Policy | Modelo | Permisos |
|--------|--------|----------|
| `UserPolicy` | User | Ver/crear: `admin`/`superadmin`. Editar/restaurar cuentas `superadmin`: solo `superadmin`. Eliminar/forceDelete: solo `superadmin` y nunca a sí mismo |
| `PostPolicy` | Post | `admin`/`superadmin` (forceDelete: solo `superadmin`) |
| `PagePolicy` | Page | `admin`/`superadmin` (forceDelete: solo `superadmin`) |
| `CategoryPolicy` | Category | `admin`/`superadmin` (forceDelete: solo `superadmin`) |
| `SlidePolicy` | Slide | `admin`/`superadmin` (forceDelete: solo `superadmin`) |
| `SectionPolicy` | Section | `admin`/`superadmin` (forceDelete: solo `superadmin`) |
| `SettingPolicy` | Setting | `admin`/`superadmin` (no permite eliminar settings) |
| `SentEmailPolicy` | SentEmail | `admin`/`superadmin` (estrictamente solo lectura) |

---

## Middlewares Globales (`bootstrap/app.php`)

### 1. `SetLocale` (`app/Http/Middleware/SetLocale.php`)
Añadido al grupo `web`. Establece el idioma activo en cada petición según este orden de prioridad:
1. Parámetro de query `?lang=xx` (si está en `config('locales.available')`, y lo persiste en sesión).
2. Valor guardado en `session('locale')`.
3. Cabecera `Accept-Language` del navegador.
4. Fallback: `config('app.locale', 'es')`.

### 2. `SecurityHeaders` (`app/Http/Middleware/SecurityHeaders.php`)
Middleware global que inyecta cabeceras de seguridad en todas las respuestas HTTP:
- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: SAMEORIGIN`
- `X-XSS-Protection: 1; mode=block`
- `Referrer-Policy: strict-origin-when-cross-origin`
- `Permissions-Policy: camera=(), microphone=(), geolocation=()`

---

## Guards de Filament (`User::canAccessPanel(Panel)`)

- **Panel Admin** (`/admin`): requiere `$this->is_active && $this->isAdmin()` (`superadmin` o `admin`).
- **Panel Usuario** (`/panel`): requiere `$this->is_active` (cualquier rol con cuenta activa).

---

## FormRequests (`app/Http/Requests/`)

- `Auth/LoginRequest.php` — Login web con rate limiter por email+IP, verificación `is_active => true` y `Recaptcha('login')`.
- `Web/ContactRequest.php` — Formulario de contacto con `Recaptcha('contact')` y mensajes traducidos (`lang/{es,en}/messages.php`).
- `Api/V1/Auth/LoginRequest.php` — Login API.
- `Api/V1/Auth/RegisterRequest.php` — Registro API.
- `Api/V1/Auth/ForgotPasswordRequest.php` — Solicitud de reset API.
- `Api/V1/Auth/ResetPasswordRequest.php` — Restablecimiento de contraseña API.
- `Api/V1/TokenCreateRequest.php` — Creación de token personal Sanctum.
