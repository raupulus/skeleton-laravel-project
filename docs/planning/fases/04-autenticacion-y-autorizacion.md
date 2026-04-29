# Fase 04 — Autenticación y autorización

## Resumen
En esta fase se configurará la autenticación web (Laravel Breeze), la autenticación API (Laravel Sanctum), las policies de autorización para cada modelo, el middleware de idioma y los guards de Filament.

**Dependencias**: Fases 01, 02 y 03 completadas.

---

## Paso 4.1 — Configurar autenticación web con Breeze

Laravel Breeze se instaló en la Fase 01. Verificar que las vistas de autenticación existen en `resources/views/auth/`:

- `login.blade.php`
- `register.blade.php`
- `forgot-password.blade.php`
- `reset-password.blade.php`
- `verify-email.blade.php`
- `confirm-password.blade.php`

Personalizar las vistas para usar el layout principal del proyecto (`layouts.app`) y asegurar que los textos están en español usando archivos de traducción.

Las rutas de autenticación web las registra Breeze automáticamente en `routes/auth.php` (incluido en `routes/web.php`).

---

## Paso 4.2 — Configurar autenticación API con Sanctum

### Controlador de autenticación API

Archivo: `app/Http/Controllers/Api/V1/AuthController.php`

```php
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Requests\Api\V1\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\V1\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

/**
 * Controlador de autenticación para la API v1.
 *
 * Gestiona: registro, login, logout, obtener usuario autenticado,
 * solicitar y resetear contraseña.
 *
 * @group Autenticación
 */
class AuthController extends Controller
{
    /**
     * Registrar un nuevo usuario.
     *
     * Crea un nuevo usuario y devuelve un token de acceso.
     *
     * @unauthenticated
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Usuario registrado correctamente.',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Iniciar sesión y obtener token.
     *
     * @unauthenticated
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        if (!$user->is_active) {
            return response()->json([
                'message' => 'Tu cuenta está desactivada.',
            ], 403);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso.',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Cerrar sesión (revocar token actual).
     *
     * @authenticated
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente.',
        ]);
    }

    /**
     * Obtener el usuario autenticado.
     *
     * @authenticated
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    /**
     * Solicitar enlace de restablecimiento de contraseña.
     *
     * @unauthenticated
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => __($status),
            ]);
        }

        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }

    /**
     * Restablecer contraseña con token.
     *
     * @unauthenticated
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'message' => __($status),
            ]);
        }

        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }
}
```

### Rutas API de autenticación

Añadir en `routes/api.php`:

```php
use App\Http\Controllers\Api\V1\AuthController;

Route::prefix('v1')->group(function () {
    // --- Autenticación ---
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('api.v1.auth.register');
        Route::post('/login', [AuthController::class, 'login'])->name('api.v1.auth.login');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('api.v1.auth.forgot-password');
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('api.v1.auth.reset-password');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout'])->name('api.v1.auth.logout');
            Route::get('/user', [AuthController::class, 'user'])->name('api.v1.auth.user');
        });
    });
});
```

---

## Paso 4.3 — Crear Policies

### `UserPolicy`

Archivo: `app/Policies/UserPolicy.php`

```php
<?php

namespace App\Policies;

use App\Models\User;

/**
 * Policy de acceso para la gestión de usuarios.
 * Solo administradores (superadmin/admin) pueden gestionar usuarios.
 */
class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->isAdmin() && $user->id !== $model->id;
    }
}
```

### Policies para contenido (Pages, Posts, Categories, Slides, Sections, Settings)

Crear las siguientes policies con la misma estructura — solo admin puede gestionar:

- `app/Policies/PagePolicy.php`
- `app/Policies/PostPolicy.php`
- `app/Policies/CategoryPolicy.php`
- `app/Policies/SlidePolicy.php`
- `app/Policies/SectionPolicy.php`
- `app/Policies/SettingPolicy.php`

Plantilla para todas (ejemplo `PagePolicy.php`):

```php
<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;

/**
 * Policy de acceso para la gestión de páginas.
 * Solo administradores pueden gestionar páginas.
 */
class PagePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Page $page): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Page $page): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Page $page): bool
    {
        return $user->isAdmin();
    }
}
```

### `SentEmailPolicy`

Archivo: `app/Policies/SentEmailPolicy.php`

```php
<?php

namespace App\Policies;

use App\Models\SentEmail;
use App\Models\User;

/**
 * Policy para emails enviados. Solo lectura para administradores.
 */
class SentEmailPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, SentEmail $sentEmail): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return false; // No se crean manualmente
    }

    public function update(User $user, SentEmail $sentEmail): bool
    {
        return false; // No se editan
    }

    public function delete(User $user, SentEmail $sentEmail): bool
    {
        return false; // No se eliminan
    }
}
```

### Registrar Policies

Archivo: `app/Providers/AppServiceProvider.php`

Añadir en el método `boot()`:

```php
use Illuminate\Support\Facades\Gate;

public function boot(): void
{
    // Registrar policies (Laravel las auto-descubre si siguen la convención de nombres,
    // pero las registramos explícitamente por claridad)
    Gate::policy(\App\Models\User::class, \App\Policies\UserPolicy::class);
    Gate::policy(\App\Models\Page::class, \App\Policies\PagePolicy::class);
    Gate::policy(\App\Models\Post::class, \App\Policies\PostPolicy::class);
    Gate::policy(\App\Models\Category::class, \App\Policies\CategoryPolicy::class);
    Gate::policy(\App\Models\Slide::class, \App\Policies\SlidePolicy::class);
    Gate::policy(\App\Models\Section::class, \App\Policies\SectionPolicy::class);
    Gate::policy(\App\Models\Setting::class, \App\Policies\SettingPolicy::class);
    Gate::policy(\App\Models\SentEmail::class, \App\Policies\SentEmailPolicy::class);
}
```

---

## Paso 4.4 — Middleware `SetLocale`

Archivo: `app/Http/Middleware/SetLocale.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para establecer el idioma de la aplicación
 * según la preferencia del usuario almacenada en sesión o la cabecera Accept-Language.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $availableLocales = config('locales.available', ['es', 'en']);

        // 1. Prioridad: parámetro de sesión
        $locale = session('locale');

        // 2. Si no hay sesión, intentar desde la cabecera Accept-Language
        if (!$locale && $request->hasHeader('Accept-Language')) {
            $preferredLocale = substr($request->header('Accept-Language'), 0, 2);
            if (in_array($preferredLocale, $availableLocales)) {
                $locale = $preferredLocale;
            }
        }

        // 3. Si no hay preferencia, usar el idioma por defecto
        $locale = $locale && in_array($locale, $availableLocales) ? $locale : config('app.locale');

        app()->setLocale($locale);

        return $next($request);
    }
}
```

Registrar el middleware globalmente en `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->append(\App\Http\Middleware\SetLocale::class);
})
```

---

## Paso 4.5 — Configurar guards de Filament

Los dos paneles Filament (Admin y Panel Usuario) usan el guard `web` con el modelo `User`. El control de acceso se hace mediante el método `canAccessPanel()` del modelo User (definido en Fase 03, Paso 3.2):

- **Panel Admin**: `$panel->getId() === 'admin'` → requiere `role->isAdmin()`
- **Panel Usuario**: Cualquier usuario activo puede acceder

No se necesitan guards adicionales. La configuración ya está en los PanelProviders (Fase 01).

---

## Checklist de verificación

- [ ] Vistas de autenticación web (Breeze) personalizadas con layout principal y textos en español
- [ ] `AuthController` API creado con métodos: register, login, logout, user, forgotPassword, resetPassword
- [ ] Rutas API de autenticación registradas en `routes/api.php` con prefijo `v1/auth`
- [ ] `UserPolicy` creada — admin puede gestionar, usuario solo puede ver/editar su propio perfil
- [ ] `PagePolicy`, `PostPolicy`, `CategoryPolicy`, `SlidePolicy`, `SectionPolicy`, `SettingPolicy` creadas — solo admin
- [ ] `SentEmailPolicy` creada — solo admin, solo lectura
- [ ] Todas las policies registradas en `AppServiceProvider`
- [ ] Middleware `SetLocale` creado y registrado globalmente
- [ ] Guards de Filament configurados vía `canAccessPanel()` en el modelo User
- [ ] Enum `Role` con método `isAdmin()` funcional
