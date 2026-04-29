# Fase 07 — Controladores y rutas (frontend público + API)

## Resumen
En esta fase se crearán todos los controladores web y API, y se definirán todas las rutas del proyecto con nombres y agrupaciones lógicas.

**Dependencias**: Fases 01-06 completadas.

---

## Paso 7.1 — Controladores Web

### `HomeController`

Archivo: `app/Http/Controllers/Web/HomeController.php`

```php
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Section;
use App\Models\Slide;
use App\Services\SeoService;

/**
 * Controlador de la página principal.
 */
class HomeController extends Controller
{
    /**
     * Mostrar la página de inicio con secciones dinámicas, slides y últimos posts.
     */
    public function index(SeoService $seo)
    {
        $sections = Section::forZone('home')->get();
        $slides = Slide::forZone('home')->get();
        $latestPosts = Post::publishedAndActive()->orderByDesc('published_at')->limit(6)->get();

        $seo->setTitle(setting('site_title', config('app.name')))
            ->setDescription(setting('site_description', ''));

        return view('home', compact('sections', 'slides', 'latestPosts', 'seo'));
    }
}
```

### `PageController`

Archivo: `app/Http/Controllers/Web/PageController.php`

```php
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\SeoService;

/**
 * Controlador para mostrar páginas estáticas en el frontend.
 */
class PageController extends Controller
{
    /**
     * Mostrar una página por su slug.
     */
    public function show(string $slug, SeoService $seo)
    {
        $page = Page::where('slug', $slug)->publishedAndActive()->firstOrFail();

        $seo->fromModel($page)->setType('article')->setUrl(url("/pages/{$page->slug}"));

        return view('pages.show', compact('page', 'seo'));
    }
}
```

### `PostController`

Archivo: `app/Http/Controllers/Web/PostController.php`

```php
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\SeoService;

/**
 * Controlador del blog: listado y detalle de posts.
 */
class PostController extends Controller
{
    /**
     * Listado de posts publicados con paginación.
     */
    public function index(SeoService $seo)
    {
        $posts = Post::publishedAndActive()
            ->with('categories', 'user')
            ->orderByDesc('published_at')
            ->paginate(12);

        $seo->setTitle(__('messages.blog') . ' - ' . setting('site_title'))
            ->setDescription(setting('site_description'));

        return view('posts.index', compact('posts', 'seo'));
    }

    /**
     * Detalle de un post por slug.
     */
    public function show(string $slug, SeoService $seo)
    {
        $post = Post::where('slug', $slug)
            ->publishedAndActive()
            ->with('categories', 'user')
            ->firstOrFail();

        $seo->fromModel($post)->setType('article')->setUrl(url("/blog/{$post->slug}"));

        return view('posts.show', compact('post', 'seo'));
    }
}
```

### `ContactController`

Archivo: `app/Http/Controllers/Web/ContactController.php`

```php
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ContactRequest;
use App\Mail\ContactMail;
use App\Services\EmailService;
use App\Services\SeoService;

/**
 * Controlador del formulario de contacto.
 */
class ContactController extends Controller
{
    /**
     * Mostrar el formulario de contacto.
     */
    public function show(SeoService $seo)
    {
        $seo->setTitle(__('messages.contact') . ' - ' . setting('site_title'));

        return view('contact', compact('seo'));
    }

    /**
     * Procesar el envío del formulario de contacto.
     */
    public function send(ContactRequest $request, EmailService $emailService)
    {
        $data = $request->validated();

        $mailable = new ContactMail($data);
        $adminEmail = setting('contact_email', config('mail.from.address'));

        $emailService->send($mailable, $adminEmail, 'Contacto: ' . $data['subject']);

        return redirect()->route('contact')
            ->with('success', __('messages.contact_success'));
    }
}
```

### `StaticPageController`

Archivo: `app/Http/Controllers/Web/StaticPageController.php`

```php
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Services\SeoService;

/**
 * Controlador para páginas estáticas de código (about, privacy, cookies).
 */
class StaticPageController extends Controller
{
    public function about(SeoService $seo)
    {
        $sections = Section::forZone('about')->get();
        $seo->setTitle(__('messages.about') . ' - ' . setting('site_title'));

        return view('about', compact('sections', 'seo'));
    }

    public function privacy(SeoService $seo)
    {
        $seo->setTitle(__('messages.privacy') . ' - ' . setting('site_title'))
            ->setRobots('noindex,follow');

        return view('privacy', compact('seo'));
    }

    public function cookies(SeoService $seo)
    {
        $seo->setTitle(__('messages.cookies') . ' - ' . setting('site_title'))
            ->setRobots('noindex,follow');

        return view('cookies', compact('seo'));
    }
}
```

### `LanguageController`

Archivo: `app/Http/Controllers/Web/LanguageController.php`

```php
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

/**
 * Controlador para cambiar el idioma de la aplicación.
 */
class LanguageController extends Controller
{
    /**
     * Cambiar idioma y redirigir a la página anterior.
     */
    public function switch(string $locale)
    {
        $availableLocales = config('locales.available', ['es', 'en']);

        if (in_array($locale, $availableLocales)) {
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }
}
```

---

## Paso 7.2 — Controladores API

### `PostApiController`

Archivo: `app/Http/Controllers/Api/V1/PostController.php`

```php
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

/**
 * Controlador API para posts (público).
 *
 * @group Posts
 */
class PostController extends Controller
{
    /**
     * Listar posts publicados.
     *
     * Devuelve posts publicados y activos, paginados.
     *
     * @unauthenticated
     * @queryParam page integer Número de página. Example: 1
     * @queryParam per_page integer Resultados por página (máx 50). Example: 12
     */
    public function index(): JsonResponse
    {
        $perPage = min(request('per_page', 12), 50);

        $posts = Post::publishedAndActive()
            ->with('categories:id,slug,name')
            ->orderByDesc('published_at')
            ->paginate($perPage);

        return response()->json($posts);
    }

    /**
     * Mostrar un post por slug.
     *
     * @unauthenticated
     * @urlParam slug string required Slug del post. Example: mi-primer-post
     */
    public function show(string $slug): JsonResponse
    {
        $post = Post::where('slug', $slug)
            ->publishedAndActive()
            ->with('categories:id,slug,name', 'user:id,name')
            ->firstOrFail();

        return response()->json($post);
    }
}
```

### `PageApiController`

Archivo: `app/Http/Controllers/Api/V1/PageApiController.php`

```php
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\JsonResponse;

/**
 * Controlador API para páginas (público).
 *
 * @group Páginas
 */
class PageApiController extends Controller
{
    /**
     * Listar páginas publicadas.
     *
     * @unauthenticated
     */
    public function index(): JsonResponse
    {
        $pages = Page::publishedAndActive()
            ->with('categories:id,slug,name')
            ->orderByDesc('published_at')
            ->paginate(min(request('per_page', 12), 50));

        return response()->json($pages);
    }

    /**
     * Mostrar una página por slug.
     *
     * @unauthenticated
     * @urlParam slug string required Slug de la página.
     */
    public function show(string $slug): JsonResponse
    {
        $page = Page::where('slug', $slug)
            ->publishedAndActive()
            ->with('categories:id,slug,name')
            ->firstOrFail();

        return response()->json($page);
    }
}
```

### `CategoryApiController`

Archivo: `app/Http/Controllers/Api/V1/CategoryApiController.php`

```php
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

/**
 * Controlador API para categorías (público).
 *
 * @group Categorías
 */
class CategoryApiController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::active()->ordered()->get();
        return response()->json($categories);
    }

    public function show(string $slug): JsonResponse
    {
        $category = Category::where('slug', $slug)->active()->firstOrFail();
        return response()->json($category);
    }
}
```

### `TokenController`

Archivo: `app/Http/Controllers/Api/V1/TokenController.php`

```php
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TokenCreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Controlador API para gestión de tokens personales.
 *
 * @group Tokens de API
 * @authenticated
 */
class TokenController extends Controller
{
    /**
     * Listar tokens del usuario autenticado.
     */
    public function index(Request $request): JsonResponse
    {
        $tokens = $request->user()->tokens()->orderByDesc('created_at')->get();
        return response()->json($tokens);
    }

    /**
     * Crear un nuevo token personal.
     */
    public function store(TokenCreateRequest $request): JsonResponse
    {
        $token = $request->user()->createToken($request->name);

        return response()->json([
            'message' => 'Token creado correctamente.',
            'token' => $token->plainTextToken,
            'name' => $request->name,
        ], 201);
    }

    /**
     * Eliminar un token personal.
     */
    public function destroy(Request $request, int $tokenId): JsonResponse
    {
        $request->user()->tokens()->where('id', $tokenId)->delete();

        return response()->json([
            'message' => 'Token eliminado correctamente.',
        ]);
    }
}
```

---

## Paso 7.3 — Definir rutas

### Rutas Web

Archivo: `routes/web.php`

```php
<?php

use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LanguageController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\PostController;
use App\Http\Controllers\Web\StaticPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Web Públicas
|--------------------------------------------------------------------------
*/

// --- Página principal ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// --- Blog ---
Route::get('/blog', [PostController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('blog.show');

// --- Páginas dinámicas ---
Route::get('/pages/{slug}', [PageController::class, 'show'])->name('pages.show');

// --- Contacto ---
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// --- Páginas estáticas ---
Route::get('/about', [StaticPageController::class, 'about'])->name('about');
Route::get('/privacy', [StaticPageController::class, 'privacy'])->name('privacy');
Route::get('/cookies', [StaticPageController::class, 'cookies'])->name('cookies');

// --- Cambio de idioma ---
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

/*
|--------------------------------------------------------------------------
| Rutas de autenticación (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
```

### Rutas API

Archivo: `routes/api.php`

```php
<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryApiController;
use App\Http\Controllers\Api\V1\PageApiController;
use App\Http\Controllers\Api\V1\PostController as PostApiController;
use App\Http\Controllers\Api\V1\TokenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas API v1
|--------------------------------------------------------------------------
*/

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

    // --- Posts (público) ---
    Route::get('/posts', [PostApiController::class, 'index'])->name('api.v1.posts.index');
    Route::get('/posts/{slug}', [PostApiController::class, 'show'])->name('api.v1.posts.show');

    // --- Páginas (público) ---
    Route::get('/pages', [PageApiController::class, 'index'])->name('api.v1.pages.index');
    Route::get('/pages/{slug}', [PageApiController::class, 'show'])->name('api.v1.pages.show');

    // --- Categorías (público) ---
    Route::get('/categories', [CategoryApiController::class, 'index'])->name('api.v1.categories.index');
    Route::get('/categories/{slug}', [CategoryApiController::class, 'show'])->name('api.v1.categories.show');

    // --- Tokens de API (autenticado) ---
    Route::middleware('auth:sanctum')->prefix('user/tokens')->group(function () {
        Route::get('/', [TokenController::class, 'index'])->name('api.v1.tokens.index');
        Route::post('/', [TokenController::class, 'store'])->name('api.v1.tokens.store');
        Route::delete('/{tokenId}', [TokenController::class, 'destroy'])->name('api.v1.tokens.destroy');
    });
});
```

---

## Checklist de verificación

- [ ] `HomeController` creado con secciones, slides y últimos posts
- [ ] `PageController` creado con vista por slug
- [ ] `PostController` web creado con listado paginado y detalle por slug
- [ ] `ContactController` creado con formulario y envío vía EmailService
- [ ] `StaticPageController` creado para about, privacy, cookies
- [ ] `LanguageController` creado para cambio de idioma en sesión
- [ ] `AuthController` API creado con register, login, logout, user, forgotPassword, resetPassword
- [ ] `PostController` API creado con index y show públicos
- [ ] `PageApiController` creado con index y show públicos
- [ ] `CategoryApiController` creado con index y show públicos
- [ ] `TokenController` creado con index, store, destroy (autenticado)
- [ ] `routes/web.php` con todas las rutas públicas nombradas
- [ ] `routes/api.php` con todas las rutas API v1 nombradas
- [ ] Eager loading aplicado en todas las queries con relaciones
- [ ] Todas las rutas tienen `->name()`
