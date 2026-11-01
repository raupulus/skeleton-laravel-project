# Manual del Administrador — Gestión de Slides

*Última actualización: 2026-08-26*

## Objetivo

El módulo de **Slides** permite gestionar las imágenes y contenido de los carruseles (sliders) que se muestran en las diferentes secciones del sitio web. Los slides son elementos visuales destacados que se utilizan por ejemplo como banner principal en la página de inicio, o como galerías de imágenes en otras secciones. Este módulo se encuentra en el grupo **Media** del menú lateral.

Cada slide puede tener contenido **multiidioma** (español e inglés) y se organiza por **zonas** que determinan dónde aparece en el frontend.

---

## Acceder al módulo

1. En el menú lateral, haz clic en el grupo **Media**.
2. Selecciona **Slides**.
3. Verás el listado de todos los slides, ordenados por zona.

---

## Listado de slides

La tabla muestra la siguiente información, agrupada visualmente por zona:

| Columna      | Descripción                                                                                  |
|--------------|----------------------------------------------------------------------------------------------|
| **Imagen**   | Miniatura de la imagen principal del slide (40px de alto).                                   |
| **Título**   | Título del slide en el idioma actual del panel.                                              |
| **Zona**     | Zona del frontend donde se muestra el slide (ej: `home`, `about`, `services`). Ordenable.    |
| **Orden**    | Posición del slide dentro de su zona. Los slides con orden menor aparecen primero. Ordenable.|
| **Activo**   | Icono que indica si el slide está activo (✓) o desactivado (✗).                              |

> El listado está ordenado por defecto por la columna **Zona**, agrupando los slides de cada zona juntos.

### Acciones

- **Editar**: Haz clic en el icono de lápiz para editar el slide.

---

## Crear un nuevo slide

1. Haz clic en el botón **Crear** en la esquina superior derecha.
2. Completa el formulario.

---

## Formulario de slide

### Pestañas de traducción

#### Pestaña «Español»

| Campo            | Tipo             | Obligatorio | Descripción                                                                                   |
|------------------|------------------|-------------|-----------------------------------------------------------------------------------------------|
| **Título (ES)**  | Texto            | ❌ No       | Título del slide en español. Se puede superponer sobre la imagen en el carrusel del frontend.  |
| **Contenido (ES)**| Texto multilínea| ❌ No       | Texto descriptivo o mensaje del slide en español. Puede mostrarse debajo o sobre la imagen como subtítulo o descripción. |

#### Pestaña «English»

| Campo            | Tipo             | Obligatorio | Descripción                                     |
|------------------|------------------|-------------|--------------------------------------------------|
| **Title (EN)**   | Texto            | ❌ No       | Título del slide en inglés.                      |
| **Content (EN)** | Texto multilínea | ❌ No       | Contenido del slide en inglés.                   |

---

### Campos generales

| Campo                | Tipo              | Obligatorio | Descripción                                                                                                      |
|----------------------|-------------------|-------------|------------------------------------------------------------------------------------------------------------------|
| **Imagen (16:9)**    | Subida de imagen  | ✅ Sí       | Imagen principal del slide en formato horizontal (proporción 16:9). **Es obligatoria.** Al subir la imagen se abrirá un **editor de recorte** integrado que te permite ajustar el encuadre manteniendo la proporción 16:9. Formatos: JPG, PNG, GIF, WebP. Se almacena en `slides`. |
| **Imagen Vertical (8:12)** | Subida de imagen | ❌ No  | Imagen alternativa en formato vertical (proporción 8:12). Se utiliza en versiones responsivas del carrusel o en diseños que requieran formato retrato. También incluye editor de recorte. Se almacena en `slides`. |
| **URL**              | Texto (URL)       | ❌ No       | Enlace al que redirige el slide cuando el usuario hace clic sobre él. Debe ser una URL completa (ej: `https://ejemplo.com/mi-pagina`). Si se deja vacío, el slide no será clicable. |
| **Zona**             | Texto             | ✅ Sí       | Zona del frontend donde se mostrará este slide. Valores comunes: `home` (página principal), `about` (sobre nosotros), `services` (servicios). Puedes crear nuevas zonas escribiendo el nombre que desees. |
| **Orden**            | Número            | ❌ No       | Posición del slide dentro de su zona. Los slides con número menor aparecen primero en el carrusel. Por defecto: 0. |
| **Activo**           | Interruptor       | ❌ No       | Indica si el slide está activo y visible en el frontend. Activado por defecto. Los slides desactivados no se muestran en el carrusel. |

---

### Uso del editor de recorte de imágenes

Al subir una imagen en los campos de imagen, se abrirá automáticamente un **editor de recorte** que te permitirá:

1. **Mover** la imagen arrastrándola para ajustar el encuadre.
2. **Hacer zoom** para acercar o alejar la imagen.
3. **Rotar** la imagen si es necesario.
4. **Confirmar el recorte** con el botón de aceptar.

El editor fuerza la proporción de recorte:
- **Imagen principal**: 16:9 (formato panorámico/horizontal)
- **Imagen vertical**: 8:12 (formato retrato)

Esto garantiza que todas las imágenes del carrusel mantengan una proporción uniforme y se visualicen correctamente.

---

## Editar un slide existente

1. En el listado, haz clic en **Editar** en la fila del slide.
2. Modifica los campos necesarios. Para cambiar la imagen, sube una nueva (la anterior será reemplazada).
3. Haz clic en **Guardar cambios**.

---

## Concepto de «Zonas»

Las zonas son etiquetas de texto libre que agrupan slides por ubicación en el frontend. El sistema viene preconfigurado con las siguientes zonas:

| Zona         | Descripción                                                     |
|--------------|-----------------------------------------------------------------|
| **home**     | Carrusel principal de la página de inicio.                      |
| **about**    | Imágenes de la página «Sobre nosotros».                         |
| **services** | Galería de la sección de servicios.                             |

Puedes crear nuevas zonas simplemente escribiendo un nuevo nombre en el campo «Zona» al crear un slide. El carrusel correspondiente se mostrará en aquella parte del frontend donde esté configurado para cargar la zona indicada.

---

## Ordenación de slides

Para controlar el orden en que aparecen los slides dentro de una misma zona:

1. Asigna números consecutivos (0, 1, 2, 3...) en el campo **Orden**.
2. El slide con el orden más bajo (0) aparecerá primero.
3. Si dos slides tienen el mismo orden, se mostrarán por fecha de creación.

---

## Preguntas frecuentes

**¿Cuántos slides puedo tener en una zona?**
No hay límite técnico. Sin embargo, se recomienda no superar los 5-7 slides por zona para no sobrecargar el carrusel.

**¿Puedo usar la misma imagen para la versión horizontal y vertical?**
Técnicamente sí, pero se recomienda usar imágenes diferentes optimizadas para cada formato para obtener la mejor calidad visual.

**¿Qué tamaño de imagen se recomienda?**
Para la imagen principal (16:9), se recomienda al menos 1920×1080 píxeles. Para la imagen vertical (8:12), al menos 800×1200 píxeles.

**¿Qué formato de imagen debo usar?**
Las imágenes deben estar en formato **WebP** para mejor rendimiento. Al subir la imagen, el editor integrado la procesará. Las imágenes de muestra del sistema ya están en formato WebP.

**¿Qué pasa si desactivo todos los slides de una zona?**
El carrusel de esa zona simplemente no se mostrará en el frontend (el espacio quedará vacío o se ocultará automáticamente).
