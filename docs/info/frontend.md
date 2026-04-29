# Módulo: Frontend público

> Layout principal, barra de navegación, pie de página, componentes Blade reutilizables y páginas públicas del sitio web con Tailwind CSS y Alpine.js.

---

## Resumen

El frontend público incluye el layout HTML5 con Tailwind CSS, la barra de navegación responsive con Alpine.js, el pie de página con redes sociales, componentes Blade reutilizables (carrusel, tarjeta de post, selector de idioma, mensajes flash, secciones dinámicas, SEO) y las páginas: home, blog, detalle de post, detalle de página, about, contacto, privacidad y cookies.

---

## Archivos de layout

| Archivo | Descripción |
|---------|-------------|
| `resources/views/layouts/app.blade.php` | Layout principal HTML5 con @vite, @stack, navbar, footer |
| `resources/views/layouts/head.blade.php` | Meta tags SEO completos (OG, Twitter, JSON-LD, hreflang) |
| `resources/views/layouts/navbar.blade.php` | Barra de navegación responsive con Alpine.js |
| `resources/views/layouts/footer.blade.php` | Pie de página con copyright, enlaces legales y redes sociales |

---

## Componentes Blade

| Componente | Archivo | Descripción |
|------------|---------|-------------|
| `<x-flash-messages />` | `components/flash-messages.blade.php` | Mensajes flash (success, error, warning, info) con auto-ocultado via Alpine.js |
| `<x-language-switcher />` | `components/language-switcher.blade.php` | Selector de idioma ES/EN |
| `<x-post-card :post="$post" />` | `components/post-card.blade.php` | Tarjeta de post: imagen, título, extracto, categorías, fecha, enlace |
| `<x-slide-carousel zone="home" />` | `components/slide-carousel.blade.php` | Carrusel de slides por zona con Alpine.js |
| `<x-section-block :section="$section" />` | `components/section-block.blade.php` | Bloque de sección dinámica: título, descripción, contenido, imagen |
| `<x-pagination :paginator="$posts" />` | `components/pagination.blade.php` | Paginación personalizada con Tailwind |

---

## Páginas

| Página | Vista | Ruta | Controlador |
|--------|-------|------|-------------|
| Home | `home.blade.php` | `/` | `HomeController@index` |
| Blog (listado) | `posts/index.blade.php` | `/blog` | `PostController@index` |
| Blog (detalle) | `posts/show.blade.php` | `/blog/{slug}` | `PostController@show` |
| Página dinámica | `pages/show.blade.php` | `/pages/{slug}` | `PageController@show` |
| Sobre nosotros | `about.blade.php` | `/about` | `StaticPageController@about` |
| Contacto | `contact.blade.php` | `/contact` | `ContactController@show/send` |
| Privacidad | `privacy.blade.php` | `/privacy` | `StaticPageController@privacy` |
| Cookies | `cookies.blade.php` | `/cookies` | `StaticPageController@cookies` |

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

---

## Stack frontend

| Tecnología | Uso |
|------------|-----|
| **Tailwind CSS 4** | Estilos utility-first |
| **Alpine.js 3** | Interactividad ligera (menú hamburguesa, carrusel, flash messages) |
| **Vue 3** | Preparado (componentes en `resources/js/components/`), no usado en producción todavía |
| **Vite** | Bundler de assets (CSS + JS) |
