# Manual del Administrador — Gestión de Secciones

*Última actualización: 2026-08-26*

## Objetivo

El módulo de **Secciones** permite gestionar bloques de contenido dinámico que se muestran en las distintas páginas del frontend. Las secciones son piezas de contenido reutilizables que pueden incluir un título, descripción, contenido enriquecido e imagen, y se agrupan por zonas. Son la principal herramienta para editar textos del frontend sin necesidad de modificar código. Este módulo se encuentra en el grupo **Frontend** del menú lateral.

Las secciones son **multiidioma** (español e inglés), lo que permite ofrecer contenido traducido automáticamente según el idioma del visitante.

---

## Acceder al módulo

1. En el menú lateral, haz clic en el grupo **Frontend**.
2. Selecciona **Secciones**.
3. Verás el listado de todas las secciones, ordenadas por zona.

---

## Listado de secciones

| Columna    | Descripción                                                                          |
|------------|--------------------------------------------------------------------------------------|
| **Slug**   | Identificador único de la sección (ej: `home-features`). Ordenable.                 |
| **Zona**   | Zona del frontend donde se usa esta sección (ej: `home`, `about`, `contact`). Ordenable. |
| **Título** | Título de la sección en el idioma actual del panel.                                  |
| **Orden**  | Número que determina la posición de la sección dentro de su zona. Ordenable.         |

> El listado está ordenado por defecto por **Zona**, agrupando visualmente las secciones de cada zona.

### Acciones

- **Editar**: Haz clic en el icono de lápiz para editar la sección.

---

## Crear una nueva sección

1. Haz clic en el botón **Crear** en la esquina superior derecha.
2. Completa el formulario.

---

## Formulario de sección

### Pestañas de traducción

#### Pestaña «Español»

| Campo                | Tipo               | Obligatorio | Descripción                                                                                                      |
|----------------------|--------------------|-------------|------------------------------------------------------------------------------------------------------------------|
| **Título (ES)**      | Texto              | ❌ No       | Título de la sección en español. Se muestra como encabezado del bloque de contenido en el frontend.               |
| **Descripción (ES)** | Texto multilínea   | ❌ No       | Breve descripción o subtítulo de la sección en español. Se muestra debajo del título, antes del contenido principal. Útil para introducir el tema de la sección. |
| **Contenido (ES)**   | Editor enriquecido | ❌ No       | Contenido principal de la sección en español. Permite formato enriquecido con negrita, cursiva, listas, enlaces, imágenes, tablas, etc. Este es el cuerpo del bloque de la sección. |

#### Pestaña «English»

| Campo                | Tipo               | Obligatorio | Descripción                                     |
|----------------------|--------------------|-------------|--------------------------------------------------|
| **Title (EN)**       | Texto              | ❌ No       | Título en inglés.                                |
| **Description (EN)** | Texto multilínea   | ❌ No       | Descripción en inglés.                           |
| **Content (EN)**     | Editor enriquecido | ❌ No       | Contenido en inglés.                             |

---

### Campos generales

| Campo       | Tipo              | Obligatorio | Descripción                                                                                                      |
|-------------|-------------------|-------------|------------------------------------------------------------------------------------------------------------------|
| **Slug**    | Texto             | ❌ No       | Identificador único de la sección (ej: `home-features`, `about-team`, `contact-info`). Se genera automáticamente si se deja vacío. Debe ser único en todo el sistema. Solo letras minúsculas, números y guiones. |
| **Zona**    | Texto             | ✅ Sí       | Zona del frontend donde aparecerá esta sección. Determina en qué página se mostrará el bloque. Valores comunes: `home`, `about`, `contact`. Puedes crear nuevas zonas escribiendo un nombre diferente. |
| **Imagen**  | Subida de imagen  | ❌ No       | Imagen asociada a la sección. Se puede mostrar junto al contenido del bloque en el frontend (ej: a la izquierda o derecha del texto, como fondo, etc.). Se almacena en `sections`. Formatos: JPG, PNG, GIF, WebP. |
| **Orden**   | Número            | ❌ No       | Posición de la sección dentro de su zona. Los números menores aparecen primero. Por defecto: 0.                   |

---

## Concepto de «Zonas» en secciones

Las zonas son etiquetas que agrupan secciones por la página del frontend donde se muestran. El sistema viene preconfigurado con las siguientes zonas:

| Zona         | Dónde se muestra                                                              | Ejemplo de secciones                                  |
|--------------|-------------------------------------------------------------------------------|-------------------------------------------------------|
| **home**     | Página de inicio, debajo del carrusel y antes del listado de posts.           | «Características», «Servicios», «Testimonios»         |
| **about**    | Página «Sobre nosotros».                                                      | «Nuestra historia», «Nuestro equipo», «Misión»        |
| **contact**  | Página de contacto, junto al formulario.                                      | «Cómo encontrarnos», «Horario de atención»            |

Puedes crear nuevas zonas escribiendo un nombre diferente en el campo «Zona». Para que una nueva zona aparezca en el frontend, el equipo de desarrollo debe configurar la vista correspondiente.

---

## Cómo se muestran las secciones en el frontend

Las secciones de cada zona se cargan automáticamente y se renderizan en el frontend mediante el componente `<x-section-block>`. Este componente:

1. Muestra el **título** como encabezado.
2. Muestra la **descripción** como subtítulo.
3. Renderiza el **contenido enriquecido** con todo el formato aplicado.
4. Muestra la **imagen** si está disponible.
5. Detecta automáticamente el **idioma del visitante** y muestra el contenido traducido correspondiente.

---

## Editar una sección existente

1. En el listado, haz clic en **Editar** en la fila de la sección.
2. Modifica los campos necesarios.
3. Haz clic en **Guardar cambios**.

Los cambios se reflejan inmediatamente en el frontend, sin necesidad de acciones adicionales.

---

## Diferencia entre Secciones y Páginas

| Aspecto          | Secciones                                      | Páginas                                       |
|------------------|-------------------------------------------------|-----------------------------------------------|
| **Propósito**    | Bloques de contenido embebidos en otras páginas | Páginas completas con su propia URL           |
| **URL propia**   | No                                              | Sí (`/pages/{slug}`)                          |
| **Ubicación**    | Dentro de una zona de una página existente      | Independientes                                |
| **Ejemplo**      | «Nuestro equipo» en la página About             | «Términos y condiciones»                      |

---

## Flujo de trabajo recomendado

1. **Identificar** qué textos del frontend necesitas editar.
2. **Localizar** la sección correspondiente por su slug y zona.
3. **Editar** el contenido en español (y opcionalmente en inglés).
4. **Verificar** los cambios visitando la página correspondiente del frontend.

---

## Preguntas frecuentes

**¿Los cambios se ven inmediatamente en la web?**
Sí, al guardar una sección, los cambios se reflejan de inmediato en el frontend.

**¿Puedo crear una nueva sección y que aparezca automáticamente en el frontend?**
Solo si la zona ya está configurada para mostrarse en alguna página del frontend. Las secciones de una zona existente (como `home`, `about`, `contact`) aparecerán automáticamente. Para zonas nuevas, se necesita trabajo de desarrollo.

**¿Puedo reordenar las secciones dentro de una zona?**
Sí, modificando el campo **Orden** de cada sección. Las secciones se renderizan en el frontend de menor a mayor orden.

**¿Puedo usar HTML personalizado en el contenido?**
El editor enriquecido genera HTML automáticamente. No se recomienda insertar HTML manualmente a menos que tengas conocimientos técnicos, ya que podría afectar al diseño de la página.
