# Fase 08 — Vistas Blade (frontend público)

## Resumen
En esta fase se crearán todos los layouts, componentes Blade reutilizables, páginas del frontend público, templates de email y la integración de Vue 3. Los meta tags SEO se mejorarán respecto al proyecto anterior con Open Graph completo, Twitter Cards, canonical, hreflang y JSON-LD.

**Dependencias**: Fases 01-07 completadas.

---

## Paso 8.1 — Layout principal

### `app.blade.php`

Archivo: `resources/views/layouts/app.blade.php`

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head_css')
        @stack('head_js')
    </head>
    <body class="min-h-screen bg-gray-50 text-gray-900 flex flex-col">
        @include('layouts.navbar')
        <x-flash-messages />
        @yield('header')

        <main class="flex-1">
            @yield('content')
        </main>

        @include('layouts.footer')
        @stack('scripts')
    </body>
</html>
```

---

## Paso 8.2 — Layout `head.blade.php` (Meta tags SEO completos)

Archivo: `resources/views/layouts/head.blade.php`

```blade
@php
    $seoData = isset($seo) ? $seo->toArray() : [];
    $pageTitle = $seoData['title'] ?? setting('site_title', config('app.name'));
    $pageDescription = $seoData['description'] ?? setting('site_description', '');
    $pageKeywords = $seoData['keywords'] ?? setting('default_meta_keywords', '');
    $pageImage = $seoData['image'] ?? asset('images/redes-sociales/rs-1200x1200.png');
    $pageUrl = $seoData['url'] ?? url()->current();
    $pageType = $seoData['type'] ?? 'website';
    $pageRobots = $seoData['robots'] ?? 'index,follow';
    $currentLocale = app()->getLocale();
    $alternateLocale = $currentLocale === 'es' ? 'en' : 'es';
@endphp

{{-- Metadatos básicos --}}
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

{{-- Idioma --}}
<meta http-equiv="Content-Language" content="{{ $currentLocale }}" />
<meta name="distribution" content="global" />

{{-- Título y SEO básico --}}
<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}" />
<meta name="keywords" content="{{ $pageKeywords }}" />
<meta name="author" content="{{ $seoData['author'] ?? setting('site_title', config('app.name')) }}" />
<meta name="robots" content="{{ $pageRobots }}" />

{{-- Canonical y Hreflang --}}
<link rel="canonical" href="{{ $pageUrl }}" />
<link rel="alternate" hreflang="{{ $currentLocale }}" href="{{ $pageUrl }}" />
<link rel="alternate" hreflang="{{ $alternateLocale }}" href="{{ $pageUrl }}" />
<link rel="alternate" hreflang="x-default" href="{{ $pageUrl }}" />

{{-- Open Graph --}}
<meta property="og:locale" content="{{ $currentLocale === 'es' ? 'es_ES' : 'en_US' }}" />
<meta property="og:locale:alternate" content="{{ $alternateLocale === 'es' ? 'es_ES' : 'en_US' }}" />
<meta property="og:title" content="{{ $pageTitle }}" />
<meta property="og:site_name" content="{{ setting('site_title', config('app.name')) }}" />
<meta property="og:type" content="{{ $pageType }}" />
<meta property="og:description" content="{{ $pageDescription }}" />
<meta property="og:image" content="{{ $pageImage }}" />
<meta property="og:image:alt" content="{{ $pageDescription }}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="1200" />
<meta property="og:url" content="{{ $pageUrl }}" />

{{-- Twitter Cards --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="{{ setting('twitter_url', '') }}" />
<meta name="twitter:creator" content="{{ setting('twitter_url', '') }}" />
<meta name="twitter:title" content="{{ $pageTitle }}" />
<meta name="twitter:description" content="{{ $pageDescription }}" />
<meta name="twitter:image" content="{{ $pageImage }}" />

{{-- Artículo (si es post/página) --}}
@if($pageType === 'article' && isset($seoData['publishedAt']))
<meta property="article:published_time" content="{{ $seoData['publishedAt'] }}" />
@endif

{{-- JSON-LD Structured Data --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "{{ $pageType === 'article' ? 'Article' : 'WebSite' }}",
    "name": "{{ $pageTitle }}",
    "description": "{{ $pageDescription }}",
    "url": "{{ $pageUrl }}",
    "image": "{{ $pageImage }}"
    @if($pageType === 'article' && isset($seoData['author']))
    ,"author": { "@type": "Person", "name": "{{ $seoData['author'] }}" }
    @endif
}
</script>

{{-- Favicons --}}
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logos/180x180.png') }}" />
<link rel="icon" type="image/png" sizes="64x64" href="{{ asset('images/logos/64x64.png') }}" />
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logos/32x32.png') }}" />
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logos/16x16.png') }}" />
```

---

## Paso 8.3 — Navbar, Footer, Alerts

### `navbar.blade.php`

Archivo: `resources/views/layouts/navbar.blade.php`

Barra de navegación responsive con Tailwind + Alpine.js. Incluir:
- Logo enlazado al home
- Menú: Inicio, Blog, Sobre nosotros, Contacto
- Selector de idioma (componente `x-language-switcher`)
- Botones Login/Register (si no autenticado) o Perfil/Logout (si autenticado)
- Menú hamburguesa para móvil con Alpine.js (`x-data="{ open: false }"`)

### `footer.blade.php`

Archivo: `resources/views/layouts/footer.blade.php`

Pie de página con:
- Copyright dinámico con año actual y nombre del sitio desde settings
- Enlaces: Privacidad, Cookies, Contacto
- Redes sociales desde settings (facebook_url, twitter_url, instagram_url, etc.)

### `alerts.blade.php` (gestionado por componente)

Archivo: `resources/views/layouts/alerts.blade.php`

Incluir el componente `<x-flash-messages />` que muestra mensajes de sesión flash.

---

## Paso 8.4 — Componentes Blade reutilizables

### `x-flash-messages`

Archivo: `resources/views/components/flash-messages.blade.php`

```blade
{{-- Mensajes flash con Alpine.js para auto-ocultar --}}
@foreach (['success', 'error', 'warning', 'info'] as $type)
    @if (session($type))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="max-w-4xl mx-auto mt-4 px-4">
            <div class="p-4 rounded-lg {{ match($type) {
                'success' => 'bg-green-100 text-green-800 border border-green-200',
                'error' => 'bg-red-100 text-red-800 border border-red-200',
                'warning' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                'info' => 'bg-blue-100 text-blue-800 border border-blue-200',
            } }}">
                {{ session($type) }}
            </div>
        </div>
    @endif
@endforeach
```

### `x-language-switcher`

Archivo: `resources/views/components/language-switcher.blade.php`

Selector de idioma que muestra banderas o textos (ES/EN) con enlaces a `route('language.switch', $locale)`.

### `x-post-card`

Archivo: `resources/views/components/post-card.blade.php`

Tarjeta de post con: imagen, título, excerpt, categorías, fecha, enlace "Leer más". Props: `$post`.

### `x-slide-carousel`

Archivo: `resources/views/components/slide-carousel.blade.php`

Carrusel de slides con Alpine.js. Props: `$zone`. Consulta los slides activos de la zona y los muestra con navegación.

### `x-section-block`

Archivo: `resources/views/components/section-block.blade.php`

Bloque que renderiza una sección dinámica. Props: `$zone`, `$slug` (opcional). Muestra title, description, content, image.

### `x-seo-meta`

Archivo: `resources/views/components/seo-meta.blade.php`

Componente que genera meta tags SEO a partir de un modelo con HasSeo. Props: `$model`.

### `x-pagination`

Archivo: `resources/views/components/pagination.blade.php`

Paginación personalizada con Tailwind. Props: `$paginator`.

---

## Paso 8.5 — Páginas del frontend

### Home

Archivo: `resources/views/home.blade.php`

```blade
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    {{-- Hero / Slides --}}
    <x-slide-carousel zone="home" />

    {{-- Secciones dinámicas de la home --}}
    @foreach($sections as $section)
        <x-section-block :section="$section" />
    @endforeach

    {{-- Últimos posts --}}
    <section class="mt-16">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">{{ __('messages.blog') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($latestPosts as $post)
                <x-post-card :post="$post" />
            @endforeach
        </div>
        <div class="mt-8 text-center">
            <a href="{{ route('blog.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                {{ __('messages.read_more') }}
            </a>
        </div>
    </section>

    {{-- Vue 3 ejemplo (opcional) --}}
    <div id="vue-app" class="mt-16">
        <example-component />
    </div>
</div>
@endsection
```

### Listado de blog, detalle de post, detalle de página, about, contact, privacy, cookies

Crear cada vista siguiendo el mismo patrón: `@extends('layouts.app')`, `@section('content')`, uso de componentes.

Archivos a crear:
- `resources/views/posts/index.blade.php` — Listado con paginación
- `resources/views/posts/show.blade.php` — Detalle del post con SEO dinámico
- `resources/views/pages/show.blade.php` — Detalle de página con SEO dinámico
- `resources/views/about.blade.php` — Secciones zone='about'
- `resources/views/contact.blade.php` — Formulario con validación
- `resources/views/privacy.blade.php` — Texto de política de privacidad
- `resources/views/cookies.blade.php` — Texto de política de cookies

### Páginas de error

- `resources/views/errors/404.blade.php` — Diseño personalizado con Tailwind
- `resources/views/errors/500.blade.php` — Diseño personalizado con Tailwind

---

## Paso 8.6 — Templates de email

### Layout base de emails

Archivo: `resources/views/mail/layouts/base.blade.php`

```blade
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        {{-- Header --}}
        <div style="background-color: #4f46e5; padding: 20px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">{{ setting('site_title', config('app.name')) }}</h1>
        </div>

        {{-- Contenido --}}
        <div style="padding: 30px;">
            @yield('content')
        </div>

        {{-- Footer --}}
        <div style="background-color: #f9fafb; padding: 15px; text-align: center; font-size: 12px; color: #6b7280;">
            <p>&copy; {{ date('Y') }} {{ setting('site_title', config('app.name')) }}. {{ __('messages.all_rights_reserved') }}.</p>
        </div>
    </div>
</body>
</html>
```

### Email de contacto

Archivo: `resources/views/mail/contact.blade.php`

```blade
@extends('mail.layouts.base')

@section('content')
    <h2 style="color: #1f2937;">Nuevo mensaje de contacto</h2>
    <p><strong>Nombre:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Asunto:</strong> {{ $data['subject'] }}</p>
    <hr style="border: 1px solid #e5e7eb;">
    <p>{{ $data['message'] }}</p>
@endsection
```

### Email de bienvenida y genérico

Crear de forma análoga:
- `resources/views/mail/welcome.blade.php` — Bienvenida al nuevo usuario
- `resources/views/mail/generic.blade.php` — Email genérico con título y contenido dinámico

---

## Paso 8.7 — Integración Vue 3

Verificar que los archivos creados en Fase 01 están correctos:

- `vite.config.js` con plugin Vue
- `resources/js/app.js` montando Vue 3 en `#vue-app`
- `resources/js/components/ExampleComponent.vue`

La directiva `@vite` en el layout carga automáticamente los assets compilados.

Para usar Vue en una vista Blade, añadir un elemento con `id="vue-app"` y dentro colocar componentes Vue registrados.

---

## Checklist de verificación

- [ ] Layout `app.blade.php` creado con estructura HTML5 semántica y Tailwind
- [ ] Layout `head.blade.php` con meta tags SEO completos:
  - [ ] charset, viewport, csrf-token
  - [ ] Content-Language dinámico
  - [ ] title, description, keywords, author, robots
  - [ ] Canonical URL
  - [ ] Hreflang (es, en, x-default)
  - [ ] Open Graph completo (locale, title, site_name, type, description, image, image:alt, image:width, image:height, url)
  - [ ] Twitter Cards (summary_large_image, site, creator, title, description, image)
  - [ ] JSON-LD structured data
  - [ ] Favicons (apple-touch-icon, 64x64, 32x32, 16x16)
- [ ] `navbar.blade.php` responsive con Alpine.js y selector de idioma
- [ ] `footer.blade.php` con copyright dinámico y redes sociales
- [ ] Componentes Blade creados: flash-messages, language-switcher, post-card, slide-carousel, section-block, seo-meta, pagination
- [ ] Páginas creadas: home, blog/index, blog/show, pages/show, about, contact, privacy, cookies
- [ ] Páginas de error personalizadas: 404, 500
- [ ] Layout de emails `mail/layouts/base.blade.php` con estilos inline
- [ ] Templates de email: contact, welcome, generic
- [ ] Vue 3 integrado y componente de ejemplo funcionando
