# Manual del Administrador — Introducción

## ¿Qué es el Panel de Administración?

El **Panel de Administración** es la herramienta central desde la que se gestiona todo el contenido, los usuarios, la configuración y los elementos visuales de la plataforma. Está construido sobre Filament y se accede desde la ruta `/admin`.

---

## ¿Quién puede acceder?

Solo los usuarios con los roles **superadmin** o **admin** que tengan la cuenta activa (`is_active = true`) pueden acceder al panel de administración. Los usuarios con rol `user` no tienen acceso a esta sección.

- **Superadmin**: Control total del sistema. Puede gestionar cualquier recurso sin restricciones.
- **Admin**: Tiene los mismos permisos de gestión que el superadmin dentro del panel de administración.

---

## ¿Cómo acceder?

1. Abre tu navegador y dirígete a `https://tu-dominio.com/admin`.
2. Introduce tu **email** y **contraseña** de administrador.
3. Pulsa el botón **Iniciar sesión**.

Si tus credenciales son correctas y tu cuenta está activa, serás redirigido al **Dashboard** (panel principal).

> **Nota:** Si has olvidado tu contraseña, utiliza la opción «Olvidé mi contraseña» en la pantalla de inicio de sesión.

---

## Estructura del menú lateral

El menú lateral del panel de administración está organizado en **grupos de navegación** para facilitar el acceso rápido a cada módulo:

| Grupo        | Módulos incluidos                           |
|--------------|---------------------------------------------|
| **Contenido**| Páginas, Posts, Categorías                  |
| **Media**    | Slides                                      |
| **Frontend** | Secciones                                   |
| **Sistema**  | Usuarios, Configuración, Emails Enviados    |

Cada módulo se explica en detalle en su propio archivo de este manual.

---

## Conceptos generales

### Traducciones (Español / Inglés)

La plataforma es **bilingüe** (español e inglés). Al crear o editar contenido como páginas, posts, categorías, slides y secciones, verás **pestañas de idioma** (Español / English). Debes completar al menos los campos en español (obligatorio). Los campos en inglés son opcionales pero recomendables para llegar a más audiencia.

### Estados del contenido

Las páginas y posts pueden tener dos estados:

- **Borrador (Draft)**: El contenido no es visible en el frontend público. Úsalo mientras trabajas en la redacción.
- **Publicado (Published)**: El contenido es visible públicamente en la web.

### Slug (URL amigable)

El **slug** es la parte de la URL que identifica un contenido de forma legible. Por ejemplo, si el slug de un post es `mi-primer-articulo`, su URL será `https://tu-dominio.com/blog/mi-primer-articulo`. El slug se genera automáticamente a partir del título, pero puedes personalizarlo manualmente.

> **Importante:** El slug debe ser único. No pueden existir dos contenidos del mismo tipo con el mismo slug.

### Imágenes

Cuando subas imágenes desde el panel:
- El archivo se almacena en el servidor automáticamente.
- Puedes arrastrar y soltar o hacer clic para seleccionar el archivo.
- Algunas imágenes (como las de slides) incluyen un **editor de recorte** integrado que se abrirá tras subir la imagen.

### Eliminación en lote

En los listados que lo permiten (por ejemplo, Usuarios), puedes seleccionar varios registros marcando las casillas de la izquierda y luego usar la acción **Eliminar seleccionados** que aparece en la barra superior.

---

## Índice de módulos

1. [Dashboard](01-dashboard.md)
2. [Usuarios](02-usuarios.md)
3. [Páginas](03-paginas.md)
4. [Posts (Blog)](04-posts.md)
5. [Categorías](05-categorias.md)
6. [Slides](06-slides.md)
7. [Secciones](07-secciones.md)
8. [Configuración](08-configuracion.md)
9. [Emails Enviados](09-emails-enviados.md)
10. [Acciones del sistema](10-acciones.md)
