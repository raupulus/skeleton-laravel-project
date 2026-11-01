# Catálogo de Componentes UI Reutilizables (COMPONENTS.md)

*Última actualización: 2026-08-26*

> Catálogo completo de componentes Blade disponibles en `resources/views/components/`. Contiene la especificación de tags, propiedades, variantes visuales y ejemplos prácticos de uso.

---

## ⚠️ Directriz Obligatoria de Reutilización

> **PROHIBICIÓN ESTRICTA**: Queda terminantemente prohibido a cualquier agente de IA o desarrollador maquetar botones, inputs, modales, alertas o dropdowns utilizando clases CSS o utilidades de Tailwind manuales cuando ya exista un componente Blade equivalente en `resources/views/components/`. 
>
> Toda vista o módulo nuevo debe hacer uso de estos componentes para garantizar consistencia visual, accesibilidad y facilitar el mantenimiento centralizado del diseño.

---

## Índice de Componentes

1. [Botones](#1-botones)
   - [x-primary-button](#x-primary-button)
   - [x-secondary-button](#x-secondary-button)
   - [x-danger-button](#x-danger-button)
2. [Formularios e Inputs](#2-formularios-e-inputs)
   - [x-text-input](#x-text-input)
   - [x-input-label](#x-input-label)
   - [x-input-error](#x-input-error)
   - [x-recaptcha-script](#x-recaptcha-script)
3. [Notificaciones y Alertas](#3-notificaciones-y-alertas)
   - [x-flash-messages](#x-flash-messages)
   - [x-auth-session-status](#x-auth-session-status)
4. [Navegación e Interactividad](#4-navegacion-e-interactividad)
   - [x-nav-link](#x-nav-link)
   - [x-responsive-nav-link](#x-responsive-nav-link)
   - [x-dropdown](#x-dropdown)
   - [x-dropdown-link](#x-dropdown-link)
   - [x-modal](#x-modal)
   - [x-language-switcher](#x-language-switcher)
5. [Contenido y Media](#5-contenido-y-media)
   - [x-post-card](#x-post-card)
   - [x-section-block](#x-section-block)
   - [x-slide-carousel](#x-slide-carousel)
   - [x-pagination](#x-pagination)
   - [x-application-logo](#x-application-logo)

---

## 1. Botones

### `x-primary-button`
Botón de acción principal de la interfaz. Estilo sólido de alta jerarquía.

- **Archivo**: `resources/views/components/primary-button.blade.php`
- **Atributos aceptados**: Atributos HTML estándar (`type`, `class`, `disabled`, `wire:click`, `@click`).
- **Variante visual**: Fondo oscuro (`bg-gray-800`), hover interactivo, texto blanco en mayúsculas pequeñas con tracking espaciado.

```blade
<x-primary-button>
    {{ __('messages.save') }}
</x-primary-button>
```

### `x-secondary-button`
Botón secundario para acciones alternativas o de cancelación.

- **Archivo**: `resources/views/components/secondary-button.blade.php`
- **Atributos aceptados**: Atributos HTML estándar (`type`, `class`, `disabled`, etc.).
- **Variante visual**: Fondo blanco (`bg-white`), borde gris neutro (`border-gray-300`), texto gris oscuro (`text-gray-700`), hover suave.

```blade
<x-secondary-button wire:click="cancel">
    {{ __('messages.cancel') }}
</x-secondary-button>
```

### `x-danger-button`
Botón para acciones destructivas (eliminar cuentas, purgar datos).

- **Archivo**: `resources/views/components/danger-button.blade.php`
- **Atributos aceptados**: Atributos HTML estándar (`type`, `class`, etc.).
- **Variante visual**: Fondo rojo intenso (`bg-red-600`), hover oscurecido (`hover:bg-red-500`), texto blanco en mayúsculas.

```blade
<x-danger-button @click="$dispatch('open-modal', 'confirm-deletion')">
    {{ __('messages.delete') }}
</x-danger-button>
```

---

## 2. Formularios e Inputs

### `x-text-input`
Campo de texto normalizado con estados focus y validación.

- **Archivo**: `resources/views/components/text-input.blade.php`
- **Propiedades**:
  - `disabled` (bool, default `false`): Si el campo se encuentra deshabilitado.
- **Atributos aceptados**: `type`, `name`, `id`, `value`, `placeholder`, `required`, etc.

```blade
<x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
```

### `x-input-label`
Etiqueta de formulario accesible.

- **Archivo**: `resources/views/components/input-label.blade.php`
- **Propiedades**:
  - `value` (string, opcional): Texto del label (o contenido del slot).
  - `for` (string): Identificador del input asociado.

```blade
<x-input-label for="email" :value="__('messages.email')" />
```

### `x-input-error`
Renderizador de mensajes de error de validación de Laravel.

- **Archivo**: `resources/views/components/input-error.blade.php`
- **Propiedades**:
  - `messages` (array|string): Lista de errores asociados al campo.

```blade
<x-input-error :messages="$errors->get('email')" class="mt-2" />
```

### `x-recaptcha-script`
Integración invisible de Google reCAPTCHA v3 para formularios públicos.

- **Archivo**: `resources/views/components/recaptcha-script.blade.php`
- **Propiedades**:
  - `action` (string, default `'submit'`): Nombre de la acción para el análisis de riesgo de Google.

```blade
<form method="POST" action="{{ route('contact.send') }}">
    @csrf
    <x-recaptcha-script action="contact" />
    <x-primary-button>{{ __('messages.send') }}</x-primary-button>
</form>
```

---

## 3. Notificaciones y Alertas

### `x-flash-messages`
Contenedor global de mensajes flash de sesión (`success`, `error`, `status`, `warning`).

- **Archivo**: `resources/views/components/flash-messages.blade.php`
- **Uso**: Ubicado en el layout principal; muestra alertas flotantes auto-descartables con Alpine.js.

```blade
<x-flash-messages />
```

### `x-auth-session-status`
Alerta informativa para estados de autenticación (ej: enlace enviado).

- **Archivo**: `resources/views/components/auth-session-status.blade.php`
- **Propiedades**:
  - `status` (string|null): Mensaje de estado.

```blade
<x-auth-session-status class="mb-4" :status="session('status')" />
```

---

## 4. Navegación e Interactividad

### `x-nav-link`
Enlace principal de la barra de navegación de escritorio con indicador de ruta activa.

- **Archivo**: `resources/views/components/nav-link.blade.php`
- **Propiedades**:
  - `active` (bool, default `false`): Determina el estilo de pestaña activa (`border-indigo-400 text-gray-900`).

```blade
<x-nav-link :href="route('blog.index')" :active="request()->routeIs('blog.*')">
    {{ __('messages.blog') }}
</x-nav-link>
```

### `x-responsive-nav-link`
Enlace optimizado para el menú móvil deslizable.

- **Archivo**: `resources/views/components/responsive-nav-link.blade.php`
- **Propiedades**: `active` (bool).

```blade
<x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
    {{ __('messages.contact') }}
</x-responsive-nav-link>
```

### `x-dropdown` y `x-dropdown-link`
Menú desplegable accesible controlado mediante Alpine.js.

- **Archivos**: `resources/views/components/dropdown.blade.php`, `resources/views/components/dropdown-link.blade.php`
- **Slots**: `trigger` (botón disparador), `content` (enlaces y acciones).

```blade
<x-dropdown align="right" width="48">
    <x-slot name="trigger">
        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
            <div>{{ Auth::user()->name }}</div>
        </button>
    </x-slot>
    <x-slot name="content">
        <x-dropdown-link :href="route('filament.panel.pages.dashboard')">
            {{ __('messages.profile') }}
        </x-dropdown-link>
    </x-slot>
</x-dropdown>
```

### `x-modal`
Diálogo modal accesible mediante eventos globales de Alpine.js (`open-modal`, `close-modal`).

- **Archivo**: `resources/views/components/modal.blade.php`
- **Propiedades**:
  - `name` (string): Identificador único del modal.
  - `show` (bool, default `false`): Estado inicial.
  - `maxWidth` (string, default `'2xl'`): Anchura máxima (`sm`, `md`, `lg`, `xl`, `2xl`).

```blade
<x-modal name="confirm-action" focusable>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">¿Confirmar acción?</h2>
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
            <x-danger-button class="ms-3">Eliminar</x-danger-button>
        </div>
    </div>
</x-modal>
```

### `x-language-switcher`
Selector dinámico de idiomas (ES / EN) para la cabecera.

- **Archivo**: `resources/views/components/language-switcher.blade.php`

```blade
<x-language-switcher />
```

---

## 5. Contenido y Media

### `x-post-card`
Tarjeta de artículo de blog con imagen responsive, tags de categorías, fecha traducida y extracto.

- **Archivo**: `resources/views/components/post-card.blade.php`
- **Propiedades**:
  - `post` (`App\Models\Post`): Instancia del modelo con traducciones.

```blade
<x-post-card :post="$post" />
```

### `x-section-block`
Renderizador de secciones dinámicas editables desde Filament Admin.

- **Archivo**: `resources/views/components/section-block.blade.php`
- **Propiedades**:
  - `block` (`App\Models\Section`): Instancia de sección con título, descripción y contenido HTML.

```blade
<x-section-block :block="$section" />
```

### `x-slide-carousel`
Carrusel interactivo autónomo basado en Alpine.js que carga las diapositivas de una zona.

- **Archivo**: `resources/views/components/slide-carousel.blade.php`
- **Propiedades**:
  - `zone` (string): Identificador de la zona (`home`, `about`, `services`).

```blade
<x-slide-carousel zone="home" />
```

### `x-pagination`
Paginador accesible que utiliza el tema Tailwind del framework.

- **Archivo**: `resources/views/components/pagination.blade.php`
- **Propiedades**:
  - `paginator` (`Illuminate\Pagination\LengthAwarePaginator`).

```blade
<x-pagination :paginator="$posts" />
```

### `x-application-logo`
Logotipo SVG corporativo vectorial escalable.

- **Archivo**: `resources/views/components/application-logo.blade.php`
- **Atributos aceptados**: Clases de dimensión y color (`class="w-12 h-12 fill-current"`).

```blade
<x-application-logo class="w-10 h-10 text-indigo-600" />
```
