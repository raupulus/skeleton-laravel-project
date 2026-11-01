# Manual del Administrador — Gestión de Categorías

*Última actualización: 2026-08-26*

## Objetivo

El módulo de **Categorías** permite crear y gestionar las categorías que organizan el contenido del sitio web (posts y páginas). Las categorías ayudan a los visitantes a encontrar contenido relacionado y mejoran la estructura de navegación. Este módulo se encuentra en el grupo **Contenido** del menú lateral.

Las categorías son **multiidioma** (español e inglés) y pueden compartirse entre posts y páginas.

---

## Acceder al módulo

1. En el menú lateral, haz clic en el grupo **Contenido**.
2. Selecciona **Categorías**.
3. Verás el listado de todas las categorías creadas.

---

## Listado de categorías

| Columna      | Descripción                                                                             |
|--------------|-----------------------------------------------------------------------------------------|
| **Slug**     | Identificador URL de la categoría (ej: `tecnologia`). Ordenable.                       |
| **Nombre**   | Nombre de la categoría en el idioma actual. Buscable.                                   |
| **Activo**   | Icono que indica si la categoría está activa (✓) o desactivada (✗).                     |
| **Orden**    | Número que determina la posición de la categoría en los listados. Ordenable.            |

### Acciones

- **Editar**: Haz clic en el icono de lápiz para editar la categoría.

---

## Crear una nueva categoría

1. Haz clic en el botón **Crear** en la esquina superior derecha.
2. Completa el formulario.

---

## Formulario de categoría

### Pestañas de traducción

#### Pestaña «Español» (obligatoria)

| Campo               | Tipo             | Obligatorio | Descripción                                                                                    |
|---------------------|------------------|-------------|------------------------------------------------------------------------------------------------|
| **Nombre (ES)**     | Texto            | ✅ Sí       | Nombre de la categoría en español. Se mostrará en el frontend cuando el idioma sea español. Es el texto que verán los visitantes para identificar esta categoría (ej: «Tecnología», «Noticias», «Tutoriales»). |
| **Descripción (ES)**| Texto multilínea | ❌ No       | Descripción breve de la categoría en español. Puede mostrarse en páginas de listado de categorías o usarse internamente como referencia. |

#### Pestaña «English» (opcional)

| Campo               | Tipo             | Obligatorio | Descripción                                                                 |
|---------------------|------------------|-------------|-----------------------------------------------------------------------------|
| **Name (EN)**       | Texto            | ❌ No       | Nombre de la categoría en inglés. Se muestra cuando el visitante usa la web en inglés. |
| **Description (EN)**| Texto multilínea | ❌ No       | Descripción breve en inglés.                                                |

---

### Campos generales

| Campo        | Tipo              | Obligatorio | Descripción                                                                                                      |
|--------------|-------------------|-------------|------------------------------------------------------------------------------------------------------------------|
| **Slug**     | Texto             | ❌ No       | URL amigable de la categoría (ej: `tecnologia`). Se genera automáticamente desde el nombre si se deja vacío. Debe ser único. Solo letras minúsculas, números y guiones. |
| **Imagen**   | Subida de imagen  | ❌ No       | Imagen representativa de la categoría. Se almacena en la carpeta `categories`. Útil para mostrar miniaturas de categorías en el frontend. Formatos: JPG, PNG, GIF, WebP. |
| **Activo**   | Interruptor       | ❌ No       | Indica si la categoría está activa y visible. Activado por defecto. Si se desactiva, la categoría no aparecerá en los selectores de categoría al crear posts ni en el frontend. |
| **Orden**    | Número            | ❌ No       | Número que determina la posición en la que aparece la categoría respecto a las demás. Las categorías con orden menor aparecen primero. Por defecto: 0. |

---

## Editar una categoría existente

1. En el listado, haz clic en **Editar** en la fila de la categoría.
2. Modifica los campos necesarios.
3. Haz clic en **Guardar cambios**.

---

## Relación con posts y páginas

Las categorías están relacionadas con posts y páginas de forma **muchos a muchos**, lo que significa:

- Una categoría puede tener múltiples posts y múltiples páginas asignados.
- Un post o página puede pertenecer a varias categorías simultáneamente.

Cuando asignas categorías a un post o página desde sus respectivos formularios (ver [Posts](04-posts.md) y [Páginas](03-paginas.md)), se crean estas relaciones automáticamente.

> **Nota:** Eliminar una categoría no elimina los posts ni las páginas asociadas; simplemente se desvinculan.

---

## Ordenación

El campo **Orden** permite controlar en qué posición aparece cada categoría en los menús y selectores. Asigna números consecutivos (0, 1, 2, 3...) para definir el orden deseado. Las categorías sin orden (valor 0) aparecerán al principio.

---

## Preguntas frecuentes

**¿Puedo crear categorías sin asignarles contenido?**
Sí, puedes crear categorías vacías para usarlas más adelante.

**¿Qué ocurre si desactivo una categoría que tiene posts asignados?**
La categoría dejará de mostrarse en el frontend y en los selectores de categoría del panel. Los posts asignados a esa categoría no se ven afectados, pero la categoría no aparecerá como filtro para los visitantes.

**¿Puedo usar la misma categoría para posts y para páginas?**
Sí, las categorías son compartidas entre ambos tipos de contenido.

**¿La eliminación de categorías es permanente?**
No, se utiliza borrado lógico (soft delete). La categoría se marca como eliminada pero se puede recuperar.
