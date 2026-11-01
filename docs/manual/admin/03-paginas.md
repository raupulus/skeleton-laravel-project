# Manual del Administrador — Gestión de Páginas

*Última actualización: 2026-08-26*

## Objetivo

El módulo de **Páginas** permite crear, editar y gestionar páginas de contenido estático o dinámico del sitio web. Las páginas son ideales para contenido que no cambia con frecuencia, como «Sobre nosotros», «Servicios», «Términos y condiciones», etc. Este módulo se encuentra en el grupo **Contenido** del menú lateral.

Cada página es **multiidioma** (español e inglés), tiene su propia URL amigable (slug) y campos SEO independientes para optimizar su posicionamiento en buscadores.

> **Páginas legales obligatorias:** Las páginas con slug `politica-privacidad` y `politica-cookies` se crean automáticamente al instalar el proyecto y son referenciadas desde el footer y el formulario de contacto. Edita su contenido desde aquí para mantenerlas actualizadas.

---

## Acceder al módulo

1. En el menú lateral, haz clic en el grupo **Contenido**.
2. Selecciona **Páginas**.
3. Verás el listado de todas las páginas creadas.

---

## Listado de páginas

La tabla del listado muestra la siguiente información:

| Columna              | Descripción                                                                                   |
|----------------------|-----------------------------------------------------------------------------------------------|
| **Slug**             | URL amigable de la página (ej: `sobre-nosotros`). Buscable y ordenable.                       |
| **Título**           | Título de la página en el idioma actual del panel. Buscable.                                  |
| **Estado**           | Estado de publicación, mostrado como etiqueta de color: verde para «Publicado», gris para «Borrador». |
| **Destacado**        | Icono que indica si la página está marcada como destacada (✓) o no (✗).                       |
| **Fecha de publicación** | Fecha programada o real de publicación en formato `dd/mm/aaaa`. Ordenable.               |

### Filtros disponibles

| Filtro      | Tipo        | Descripción                                                              |
|-------------|-------------|--------------------------------------------------------------------------|
| **Estado**  | Desplegable | Filtra por estado: Borrador o Publicado.                                 |

### Acciones

- **Editar**: Haz clic en el icono de lápiz de cualquier fila para editar la página.

---

## Crear una nueva página

1. Haz clic en el botón **Crear** en la esquina superior derecha del listado.
2. Completa el formulario siguiendo las indicaciones de cada sección.

---

## Formulario de página

El formulario está dividido en varias secciones:

### Pestañas de traducción

En la parte superior del formulario verás dos pestañas: **Español** y **English**. Debes completar al menos los campos en español. Los campos en inglés son opcionales.

#### Pestaña «Español» (obligatoria)

| Campo                   | Tipo           | Obligatorio | Descripción                                                                                                      |
|-------------------------|----------------|-------------|------------------------------------------------------------------------------------------------------------------|
| **Título (ES)**         | Texto          | ✅ Sí       | Título principal de la página en español. Se muestra como encabezado en el frontend y se usa para generar el slug automáticamente si no se especifica uno. |
| **Contenido (ES)**      | Editor enriquecido | ❌ No  | Contenido principal de la página en español. Permite dar formato con negrita, cursiva, listas, enlaces, imágenes embebidas, tablas y más. |
| **Extracto (ES)**       | Texto multilínea | ❌ No    | Resumen breve de la página en español. Se utiliza en listados, previsualizaciones y como texto descriptivo cuando se comparte en redes sociales si no se especifica una meta descripción SEO. |
| **SEO Título (ES)**     | Texto          | ❌ No       | Título optimizado para buscadores en español. Si se deja vacío, se usará el título principal. Recomendación: máximo 60 caracteres. |
| **SEO Descripción (ES)**| Texto multilínea | ❌ No    | Meta descripción para buscadores en español. Aparece debajo del título en los resultados de Google. Recomendación: entre 120 y 160 caracteres. |
| **SEO Keywords (ES)**   | Texto          | ❌ No       | Palabras clave separadas por comas en español para los buscadores (ej: `servicios, empresa, plataforma`).         |

#### Pestaña «English» (opcional)

Los mismos campos que la pestaña en español, pero para el contenido en inglés. Estos campos se muestran cuando un usuario visita la web con el idioma configurado en inglés.

| Campo                   | Tipo           | Obligatorio | Descripción                                        |
|-------------------------|----------------|-------------|----------------------------------------------------|
| **Title (EN)**          | Texto          | ❌ No       | Título en inglés.                                  |
| **Content (EN)**        | Editor enriquecido | ❌ No  | Contenido en inglés.                               |
| **Excerpt (EN)**        | Texto multilínea | ❌ No    | Extracto en inglés.                                |
| **SEO Title (EN)**      | Texto          | ❌ No       | Meta título en inglés.                             |
| **SEO Description (EN)**| Texto multilínea | ❌ No    | Meta descripción en inglés.                        |
| **SEO Keywords (EN)**   | Texto          | ❌ No       | Palabras clave en inglés.                          |

---

### Campos generales (debajo de las pestañas)

| Campo                    | Tipo              | Obligatorio | Descripción                                                                                                      |
|--------------------------|-------------------|-------------|------------------------------------------------------------------------------------------------------------------|
| **Slug**                 | Texto             | ❌ No       | URL amigable de la página (ej: `sobre-nosotros`). Si se deja vacío, se genera automáticamente desde el título en español. Debe ser único en todo el sistema. Solo usar letras minúsculas, números y guiones. |
| **Imagen**               | Subida de imagen  | ❌ No       | Imagen principal o de cabecera de la página. Se aceptan formatos JPG, PNG, GIF, WebP. Se almacena en la carpeta `pages`. Esta imagen se puede usar como imagen destacada en listados y para compartir en redes sociales. |
| **Estado**               | Desplegable       | ❌ No       | Estado de publicación. Opciones: **Borrador** (no visible en la web) o **Publicado** (visible públicamente). Por defecto: Borrador. |
| **Destacado**            | Interruptor       | ❌ No       | Marca la página como destacada. Las páginas destacadas pueden aparecer en posiciones privilegiadas en el frontend (por ejemplo, en la página de inicio). |
| **Activo**               | Interruptor       | ❌ No       | Indica si la página está activa. Por defecto está activado. Una página inactiva no se muestra en la web incluso si está publicada. |
| **Categorías**           | Selector múltiple | ❌ No       | Permite asignar una o varias categorías a la página. Las categorías aparecen en el desplegable con su nombre traducido al idioma actual del panel. Útil para organizar y agrupar contenido. |
| **Fecha de publicación** | Selector de fecha/hora | ❌ No  | Fecha y hora en que la página se publica o se publicó. Útil para programar publicaciones futuras o registrar la fecha de publicación original. |

---

## Editar una página existente

1. En el listado, haz clic en el botón **Editar** de la página que quieras modificar.
2. Realiza los cambios necesarios en cualquier campo o pestaña de idioma.
3. Haz clic en **Guardar cambios**.

> **Consejo:** Si cambias el slug de una página que ya estaba publicada, los enlaces antiguos dejarán de funcionar. Asegúrate de actualizar cualquier enlace externo que apunte a la URL anterior.

---

## Cómo se muestra la página en la web

Las páginas publicadas son accesibles desde la URL:

```
https://tu-dominio.com/pages/{slug}
```

Por ejemplo, una página con slug `sobre-nosotros` se verá en:

```
https://tu-dominio.com/pages/sobre-nosotros
```

El sistema detecta automáticamente el idioma del visitante y muestra el contenido en el idioma correspondiente (español o inglés).

---

## Flujo de trabajo recomendado

1. **Crear la página** en estado «Borrador» y completar al menos el contenido en español.
2. **Revisar el contenido** y completar los campos SEO para mejorar el posicionamiento.
3. **Añadir la traducción al inglés** si la página debe estar disponible en ese idioma.
4. **Cambiar el estado a «Publicado»** cuando el contenido esté listo.
5. Si usas categorías, **asigna las categorías correspondientes** para que la página esté bien organizada.

---

## Preguntas frecuentes

**¿Qué diferencia hay entre una página y un post?**
Las páginas son para contenido estático y atemporal (ej: «Sobre nosotros», «Servicios»). Los posts son para contenido de tipo blog, cronológico y actualizable (ej: noticias, artículos).

**¿Puedo programar la publicación de una página?**
Puedes establecer una fecha de publicación futura, pero el cambio de estado a «Publicado» es manual. La fecha de publicación es informativa y puede usarse para ordenar contenido.

**¿Qué ocurre si elimino una página?**
La eliminación usa borrado lógico (soft delete). La página se oculta pero no se borra permanentemente de la base de datos.

**¿Para qué sirve el campo «Destacado»?**
Permite marcar páginas importantes que el frontend puede mostrar en posiciones privilegiadas, como carruseles o secciones especiales de la página principal.
