# Guía y Especificación de Diseño (DESIGN.md)

*Última actualización: 2026-08-26*

> Especificación técnica sobre arquitectura visual, maquetación, tipografía y esquema de color basado en Tailwind CSS v4.

---

## 1. Fundamentos y Filosofía Visual

El proyecto implementa un diseño corporativo, minimalista, limpio y moderno. La interfaz pública prioriza la legibilidad, la velocidad de carga y la accesibilidad (WCAG 2.1 AA), evitando artificios visuales innecesarios.

El diseño sigue una estrategia **mobile-first** estricta, asegurando que todos los componentes y plantillas se visualicen de manera óptima en pantallas pequeñas antes de escalar hacia resoluciones intermedias y de escritorio.

---

## 2. Stack de Estilos: Tailwind CSS v4

La aplicación utiliza la versión 4 de Tailwind CSS, configurada mediante la directiva `@theme` en `resources/css/app.css`:

```css
@import "tailwindcss";
@plugin "@tailwindcss/forms";

@theme {
    --font-sans: 'Figtree', ui-sans-serif, system-ui, sans-serif;
    --color-primary: #4f46e5;
    --color-primary-dark: #4338ca;
    --color-dark: #111827;
    --color-surface: #ffffff;
    --color-muted: #6b7280;
}
```


### Directrices de Tailwind v4:
- Toda la configuración se declara mediante variables CSS y directivas `@theme` nativas.
- No se deben crear archivos `tailwind.config.js` antiguos.
- Se utiliza el plugin oficial `@tailwindcss/forms` para normalizar elementos interactivos de formulario.

---

## 3. Esquema de Colores (Tokens Semánticos)

| Rol Semántico | Escala Tailwind | Código Hex Aproximado | Propósito |
|---------------|-----------------|------------------------|-----------|
| **Primary** | `indigo-600` / `indigo-700` | `#4f46e5` / `#4338ca` | Botones de acción principal, enlaces activos, badges de categorías |
| **Secondary** | `gray-800` / `gray-700` | `#1f2937` / `#374151` | Acciones neutras, botones oscuros, cabeceras |
| **Background** | `gray-50` / `white` | `#f9fafb` / `#ffffff` | Fondo general de página y tarjetas contenedoras |
| **Text Primary**| `gray-900` | `#111827` | Títulos, textos destacados y párrafos principales |
| **Text Muted** | `gray-600` / `gray-500`| `#4b5563` / `#6b7280` | Descripciones secundarias, metadatos, fechas |
| **Success** | `emerald-600` | `#059669` | Alertas de éxito, estados publicados |
| **Warning** | `amber-500` | `#f59e0b` | Alertas informativas, estados pendientes |
| **Danger** | `red-600` / `rose-600` | `#dc2626` / `#e11d48` | Errores de validación, acciones destructivas |

---

## 4. Tipografía y Escalas de Texto

La fuente oficial del proyecto es **Figtree**, optimizada para interfaces web mediante Bunny Fonts:

- **H1 (Títulos de Página)**: `text-3xl md:text-5xl font-bold tracking-tight text-gray-900`
- **H2 (Títulos de Sección)**: `text-2xl md:text-3xl font-bold text-gray-900`
- **H3 (Títulos de Tarjeta/Módulo)**: `text-lg md:text-xl font-semibold text-gray-800`
- **Párrafo general**: `text-base text-gray-600 leading-relaxed`
- **Texto pequeño / Metadatos**: `text-xs text-gray-500`

---

## 5. Estructura de Layout y Contenedores

Las vistas públicas se estructuran bajo el layout `resources/views/layouts/app.blade.php`:

1. **Header / Barra de navegación (`layouts/navbar.blade.php`)**:
   - Altura estándar `h-16`, fijada con borde inferior sutil (`border-b border-gray-100 bg-white`).
   - Logotipo a la izquierda, enlaces centrales, acciones de autenticación y selector de idioma a la derecha.
2. **Contenedor Principal (`main`)**:
   - `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8` para vistas generales o `max-w-4xl mx-auto` para lectura de artículos y formularios.
   - Espaciado vertical estándar mediante `py-8` o `py-12`.
3. **Pie de Página (`layouts/footer.blade.php`)**:
   - Fondo `bg-white` o `bg-gray-900`, borde superior sutil, enlaces legales (Privacidad, Cookies) y copyright dinámico.

---

## 6. Componentes y Reglas de Maquetación

- **Bordes redondeados**: Estándar `rounded-lg` (8px) para tarjetas y botones; `rounded-xl` (12px) para contenedores destacados; `rounded-full` para badges y avatares.
- **Sombras**: Preferir `shadow-sm` para estado neutro y elevar a `hover:shadow-md` en interacción.
- **Transiciones**: Siempre incluir `transition duration-150 ease-in-out` en hover, focus y active.
- **Formularios**: Todo input debe contar con `rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500`.

> ⚠️ **Prohibición de estilos manuales**: Consulte el catálogo de componentes en [COMPONENTS.md](COMPONENTS.md). Está expresamente prohibido maquetar botones, modales o inputs manuales con clases Tailwind si ya existe el componente Blade correspondiente (`<x-primary-button>`, `<x-secondary-button>`, `<x-text-input>`, etc.).
