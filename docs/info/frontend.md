# Módulo: Frontend público

*Última actualización: 2026-11-01*

> Layout principal, barra de navegación, pie de página, componentes Blade reutilizables y páginas públicas del sitio web con Tailwind CSS y Alpine.js.

---

## Resumen

El frontend público incluye el layout HTML5 con Tailwind CSS v4, la barra de navegación responsive con Alpine.js, el pie de página con redes sociales, componentes Blade reutilizables (carrusel, tarjeta de post, selector de idioma, mensajes flash, secciones dinámicas, script de reCAPTCHA v3, botones, inputs y modales) y las páginas: home, blog, detalle de post, detalle de página, about, contacto, privacidad y cookies.

---

## Archivos de layout

| Archivo | Descripción |
|---------|-------------|
| `resources/views/layouts/app.blade.php` | Layout principal HTML5 con `@vite`, `@stack`, navbar y footer |
| `resources/views/layouts/guest.blade.php` | Layout centrado para páginas de autenticación (`/login`, `/register`, etc.) |
| `resources/views/layouts/head.blade.php` | Meta tags SEO completos (OG, Twitter, JSON-LD, hreflang) |
| `resources/views/layouts/navbar.blade.php` | Barra de navegación responsive con Alpine.js |
| `resources/views/layouts/footer.blade.php` | Pie de página con copyright, enlaces legales y redes sociales |

---

## Componentes Blade

> Para el catálogo completo de componentes de UI (botones, inputs, labels, modales, dropdowns), consulte [COMPONENTS.md](COMPONENTS.md).

| Componente | Archivo | Descripción |
|------------|---------|-------------|
| `<x-flash-messages />` | `components/flash-messages.blade.php` | Mensajes flash (`success`, `error`, `warning`, `info`) con auto-ocultado vía Alpine.js |
| `<x-language-switcher />` | `components/language-switcher.blade.php` | Selector de idioma ES/EN |
| `<x-post-card :post="$post" />` | `components/post-card.blade.php` | Tarjeta de post: imagen, título, extracto, categorías, fecha, enlace |
| `<x-slide-carousel zone="home" />` | `components/slide-carousel.blade.php` | Carrusel de slides por zona con Alpine.js |
| `<x-section-block :section="$section" />` | `components/section-block.blade.php` | Bloque de sección dinámica: título, descripción, contenido, imagen |
| `<x-pagination :paginator="$posts" />` | `components/pagination.blade.php` | Paginación personalizada con Tailwind |
| `<x-recaptcha-script action="..." />` | `components/recaptcha-script.blade.php` | Inyección invisible de Google reCAPTCHA v3 al enviar formularios públicos |

---

## Páginas

| Página | Vista | Ruta | Controlador |
|--------|-------|------|-------------|
| Home | `home.blade.php` | `/` | `HomeController@index` |
| Blog (listado) | `posts/index.blade.php` | `/blog` | `PostController@index` |
| Blog (detalle) | `posts/show.blade.php` | `/blog/{slug}` | `PostController@show` |
| Página dinámica | `pages/show.blade.php` | `/pages/{slug}` | `PageController@show` |
| Sobre nosotros | `static/about.blade.php` | `/about` | `StaticPageController@about` |
| Contacto | `contact.blade.php` | `/contact` | `ContactController@show/send` |
| Privacidad | `static/privacy.blade.php` | `/privacy` | `StaticPageController@privacy` |
| Cookies | `static/cookies.blade.php` | `/cookies` | `StaticPageController@cookies` |

### Errores personalizados

| Vista | Descripción |
|-------|-------------|
| `errors/404.blade.php` | Página no encontrada |
| `errors/500.blade.php` | Error interno del servidor |

---

## Controladores Web

| Controlador | Ruta |
|-------------|------|
| `HomeController` | `app/Http/Controllers/Web/HomeController.php` |
| `PostController` | `app/Http/Controllers/Web/PostController.php` |
| `PageController` | `app/Http/Controllers/Web/PageController.php` |
| `ContactController` | `app/Http/Controllers/Web/ContactController.php` |
| `StaticPageController` | `app/Http/Controllers/Web/StaticPageController.php` |
| `LanguageController` | `app/Http/Controllers/Web/LanguageController.php` |
| `LogDownloadController` | `app/Http/Controllers/Web/LogDownloadController.php` |

---

## Stack frontend

| Tecnología | Uso |
|------------|-----|
| **Tailwind CSS 4** | Estilos utility-first con `@theme` en `resources/css/app.css` |
| **Alpine.js 3** | Interactividad ligera (menú hamburguesa, carrusel, flash messages, modales) |
| **Vue 3** | Preparado (componentes en `resources/js/components/`), no usado en producción todavía |
| **Vite 8 + pnpm** | Bundler de assets (CSS + JS) gestionado con `pnpm` |
