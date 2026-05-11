# Módulo: Traducciones (i18n)

> Sistema de internacionalización bilingüe (español/inglés) para textos de la interfaz y contenido de modelos, con cambio de idioma persistido en sesión.

---

## Objetivo y funcionalidad

El módulo de traducciones proporciona soporte bilingüe completo (español e inglés) a toda la plataforma. Su objetivo es que tanto los textos estáticos de la interfaz como el contenido dinámico de los modelos sean traducibles, permitiendo que usuarios de distintos idiomas accedan al sitio en su lengua preferida.

El sistema opera con dos mecanismos complementarios:

1. **Textos estáticos de la UI** (archivos de idioma): labels, botones, mensajes, títulos fijos y textos del layout se gestionan mediante los archivos `lang/es/messages.php` y `lang/en/messages.php`, accesibles con el helper `__('messages.clave')`. Al añadir una nueva clave se debe incluir en ambos archivos obligatoriamente.

2. **Contenido dinámico de modelos** (Spatie Translatable): los campos de contenido de posts, páginas, categorías, slides y secciones se almacenan como JSON en la base de datos con una versión por idioma, accesibles con `$modelo->getTranslation('campo', $locale)`. Los formularios de Filament presentan tabs por idioma (ES/EN) para editar cada versión.

El cambio de idioma se realiza desde el frontend mediante el selector de idioma (`<x-language-switcher />`), que redirige a `/lang/{locale}`. El `LanguageController` valida el idioma, lo persiste en sesión y el middleware `SetLocale` lo aplica en cada request posterior. El idioma por defecto es español, con inglés como fallback.

---

## Resumen

La plataforma soporta dos idiomas: español (por defecto) e inglés. Hay dos mecanismos de traducción: archivos de idioma para textos estáticos de la UI (`__('messages.key')`) y campos traducibles en modelos con `spatie/laravel-translatable` para contenido dinámico. El idioma se cambia con el selector del frontend y se persiste en sesión mediante el middleware `SetLocale`.

---

## Archivos principales

| Tipo | Ruta |
|------|------|
| Archivos de idioma ES | `lang/es/messages.php`, `lang/es/auth.php`, etc. |
| Archivos de idioma EN | `lang/en/messages.php`, `lang/en/auth.php`, etc. |
| Middleware | `app/Http/Middleware/SetLocale.php` |
| Controlador cambio idioma | `app/Http/Controllers/Web/LanguageController.php` |
| Componente selector | `resources/views/components/language-switcher.blade.php` |
| Config de idiomas | `config/locales.php` |

---

## Textos estáticos (archivos de idioma)

Para labels, botones, mensajes, títulos fijos de la UI:

```blade
{{ __('messages.read_more') }}
{{ __('messages.contact_success') }}
```

Los archivos de idioma se encuentran en:

| Archivo | Español (ES) | Inglés (EN) |
|---------|:---:|:---:|
| `messages.php` | ✅ `lang/es/messages.php` | ✅ `lang/en/messages.php` |
| `auth.php` | ✅ `lang/es/auth.php` | ✅ `lang/en/auth.php` |
| `pagination.php` | ✅ `lang/es/pagination.php` | ✅ `lang/en/pagination.php` |
| `passwords.php` | ✅ `lang/es/passwords.php` | ✅ `lang/en/passwords.php` |

**Regla**: Al añadir una nueva clave de traducción, se debe añadir en AMBOS archivos.

---

## Contenido de modelos (Spatie Translatable)

Los modelos de contenido almacenan sus campos traducibles como JSON en la BD y se acceden con:

```php
$post->getTranslation('title', 'es');   // Título en español
$post->getTranslation('title', 'en');   // Título en inglés
$post->getTranslation('title', app()->getLocale()); // Idioma actual
```

### Modelos con traducciones

| Modelo | Campos traducibles |
|--------|-------------------|
| Post | `title`, `content`, `excerpt`, `seo_title`, `seo_description`, `seo_keywords` |
| Page | `title`, `content`, `excerpt`, `seo_title`, `seo_description`, `seo_keywords` |
| Category | `name`, `description` |
| Slide | `title`, `content` |
| Section | `title`, `description`, `content` |

---

## Cambio de idioma

### Ruta

| Método | URI | Nombre |
|--------|-----|--------|
| GET | `/lang/{locale}` | `language.switch` |

El `LanguageController` valida que el locale esté en la lista de disponibles, lo guarda en sesión y redirige a la página anterior.

### Componente Blade

```blade
<x-language-switcher />
```

Renderiza botones/banderas ES/EN con enlaces a `route('language.switch', $locale)`.

### Middleware SetLocale

Registrado globalmente, establece el idioma en cada request:
1. Sesión → 2. Accept-Language → 3. Config por defecto

---

## Filament (panel admin)

Los formularios de Filament usan **Tabs** por idioma para editar las traducciones:

```php
Tabs::make('Traducciones')->tabs([
    Tab::make('Español')->schema([
        TextInput::make('title.es')->label('Título (ES)'),
        // ...
    ]),
    Tab::make('English')->schema([
        TextInput::make('title.en')->label('Title (EN)'),
        // ...
    ]),
]);
```
