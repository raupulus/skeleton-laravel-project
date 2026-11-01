# Manual del Administrador — Gestión de Posts (Blog)

*Última actualización: 2026-08-26*

## Objetivo

El módulo de **Posts** permite crear, editar y gestionar las publicaciones del blog de la plataforma. Los posts son contenido de tipo artículo o noticia, organizados cronológicamente y agrupables por categorías. Este módulo se encuentra en el grupo **Contenido** del menú lateral.

Al igual que las páginas, cada post es **multiidioma** (español e inglés), con campos SEO independientes para optimizar su visibilidad en buscadores.

---

## Acceder al módulo

1. En el menú lateral, haz clic en el grupo **Contenido**.
2. Selecciona **Posts**.
3. Verás el listado de todos los posts creados.

---

## Listado de posts

La tabla del listado muestra la siguiente información:

| Columna              | Descripción                                                                                   |
|----------------------|-----------------------------------------------------------------------------------------------|
| **Slug**             | URL amigable del post (ej: `mi-primer-articulo`). Buscable y ordenable.                       |
| **Título**           | Título del post en el idioma actual del panel. Buscable.                                      |
| **Estado**           | Estado de publicación, mostrado como etiqueta de color: verde para «Publicado», gris para «Borrador». |
| **Destacado**        | Icono que indica si el post está marcado como destacado (✓) o no (✗).                         |
| **Fecha de publicación** | Fecha de publicación en formato `dd/mm/aaaa`. Ordenable.                                 |

### Acciones

- **Editar**: Haz clic en el icono de lápiz para editar el post.

---

## Crear un nuevo post

1. Haz clic en el botón **Crear** en la esquina superior derecha del listado.
2. Completa el formulario siguiendo las indicaciones.

---

## Formulario de post

El formulario es muy similar al de las páginas y está dividido en las siguientes secciones:

### Pestañas de traducción

Dos pestañas: **Español** y **English**.

#### Pestaña «Español» (obligatoria)

| Campo                   | Tipo               | Obligatorio | Descripción                                                                                                      |
|-------------------------|--------------------|-------------|------------------------------------------------------------------------------------------------------------------|
| **Título (ES)**         | Texto              | ✅ Sí       | Título del post en español. Se muestra como encabezado en la página de detalle del blog y en las tarjetas de listado. Se usa para generar el slug automáticamente. |
| **Contenido (ES)**      | Editor enriquecido | ❌ No       | Cuerpo principal del artículo en español. Puedes formatear con negrita, cursiva, encabezados, listas, enlaces, imágenes, tablas, citas y más. |
| **Extracto (ES)**       | Texto multilínea   | ❌ No       | Resumen corto del post en español. Se muestra en listados del blog y en las tarjetas de previsualización. Recomendación: 1-3 frases. |
| **SEO Título (ES)**     | Texto              | ❌ No       | Título para buscadores en español. Si se deja vacío, se usa el título del post. Recomendación: máx. 60 caracteres. |
| **SEO Descripción (ES)**| Texto multilínea   | ❌ No       | Meta descripción en español para buscadores. Recomendación: entre 120 y 160 caracteres.                          |
| **SEO Keywords (ES)**   | Texto              | ❌ No       | Palabras clave en español separadas por comas.                                                                    |

#### Pestaña «English» (opcional)

| Campo                   | Tipo               | Obligatorio | Descripción                                       |
|-------------------------|--------------------|-------------|----------------------------------------------------|
| **Title (EN)**          | Texto              | ❌ No       | Título en inglés.                                  |
| **Content (EN)**        | Editor enriquecido | ❌ No       | Contenido en inglés.                               |
| **Excerpt (EN)**        | Texto multilínea   | ❌ No       | Extracto en inglés.                                |
| **SEO Title (EN)**      | Texto              | ❌ No       | Meta título en inglés.                             |
| **SEO Description (EN)**| Texto multilínea   | ❌ No       | Meta descripción en inglés.                        |
| **SEO Keywords (EN)**   | Texto              | ❌ No       | Palabras clave en inglés.                          |

---

### Campos generales (debajo de las pestañas)

| Campo                    | Tipo               | Obligatorio | Descripción                                                                                                      |
|--------------------------|--------------------|----|------------------------------------------------------------------------------------------------------------------|
| **Slug**                 | Texto              | ❌ No       | URL amigable del post. Se genera automáticamente desde el título si se deja vacío. Debe ser único. Solo usar letras minúsculas, números y guiones. |
| **Imagen**               | Subida de imagen   | ❌ No       | Imagen destacada del post. Aparece como cabecera del artículo y como miniatura en el listado del blog. Se almacena en la carpeta `posts`. Formatos: JPG, PNG, GIF, WebP. |
| **Estado**               | Desplegable        | ❌ No       | **Borrador**: no visible públicamente. **Publicado**: visible en el blog. Por defecto: Borrador.                 |
| **Destacado**            | Interruptor        | ❌ No       | Marca el post como destacado. Los posts destacados pueden mostrarse en secciones especiales del frontend, como la página principal. |
| **Activo**               | Interruptor        | ❌ No       | Si se desactiva, el post no será visible aunque esté publicado. Activo por defecto.                              |
| **Categorías**           | Selector múltiple  | ❌ No       | Asigna una o varias categorías al post. Las categorías se muestran con su nombre traducido al idioma actual. Los visitantes pueden filtrar posts por categoría en el blog. |
| **Fecha de publicación** | Selector de fecha/hora | ❌ No  | Fecha y hora de publicación. Útil para ordenar los posts cronológicamente y para los meta datos de los artículos en buscadores. |

---

## Asignación automática del autor

Al crear un post, el sistema asigna automáticamente el **usuario conectado** como autor del post. Este dato no aparece en el formulario y no se puede modificar desde el mismo. El autor se utiliza internamente para el registro de autoría y puede mostrarse en el frontend junto al post.

---

## Editar un post existente

1. En el listado, haz clic en **Editar** en la fila del post.
2. Modifica los campos necesarios.
3. Haz clic en **Guardar cambios**.

> **Nota:** Si cambias el slug de un post publicado, la URL antigua dejará de estar disponible. Actualiza los enlaces externos si es necesario.

---

## Cómo se muestran los posts en la web

### Listado del blog
Los posts publicados se muestran en la página del blog:
```
https://tu-dominio.com/blog
```
Se presentan como tarjetas con imagen, título, extracto, categorías y fecha, con paginación automática.

### Detalle del post
Cada post tiene su propia página de detalle:
```
https://tu-dominio.com/blog/{slug}
```
Se muestra el contenido completo con formato, la imagen destacada, el autor y la fecha. Los meta tags SEO se generan automáticamente a partir de los campos SEO del post.

### Página de inicio
Los últimos posts publicados también aparecen en la sección de blog de la página principal del sitio web.

---

## Flujo de trabajo recomendado

1. **Crear el post** en estado «Borrador».
2. **Redactar el contenido** en español utilizando el editor enriquecido.
3. **Añadir una imagen destacada** atractiva y representativa del contenido.
4. **Completar los campos SEO** (título, descripción, keywords) para optimizar el posicionamiento.
5. **Asignar categorías** para organizar el post temáticamente.
6. **Traducir al inglés** si es necesario.
7. **Establecer la fecha de publicación** deseada.
8. **Cambiar el estado a «Publicado»** para que aparezca en la web.

---

## Preguntas frecuentes

**¿Cuántas categorías puedo asignar a un post?**
No hay límite. Puedes asignar tantas categorías como consideres relevantes.

**¿Puedo crear un post sin imagen?**
Sí, la imagen es opcional. Sin embargo, se recomienda incluir una imagen para mejorar la apariencia en el listado y al compartir en redes sociales.

**¿Los posts eliminados se pueden recuperar?**
Sí, se usa borrado lógico (soft delete). Los posts eliminados se pueden recuperar desde la base de datos.

**¿Qué diferencia hay entre «Activo» y «Estado»?**
El **Estado** controla si el contenido está en borrador o publicado. **Activo** es un interruptor adicional que puede desactivar la visibilidad incluso de un post publicado. Para que un post sea visible, debe estar **Publicado** Y **Activo**.
