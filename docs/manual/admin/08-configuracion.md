# Manual del Administrador — Configuración del Sistema

## Objetivo

El módulo de **Configuración** permite gestionar los ajustes globales de la plataforma mediante un sistema de pares clave-valor. Desde aquí se controlan datos como el nombre del sitio, la descripción SEO por defecto, las URLs de redes sociales, la dirección de contacto y muchas otras opciones que afectan al comportamiento y aspecto de toda la web. Este módulo se encuentra en el grupo **Sistema** del menú lateral.

Los valores de configuración se utilizan en todo el frontend (cabecera, pie de página, meta tags SEO, etc.) y están **cacheados durante 1 hora** para optimizar el rendimiento.

---

## Acceder al módulo

1. En el menú lateral, haz clic en el grupo **Sistema**.
2. Selecciona **Configuración**.
3. Verás el listado de todas las configuraciones, agrupadas por categoría.

---

## Listado de configuraciones

| Columna             | Descripción                                                                          |
|---------------------|--------------------------------------------------------------------------------------|
| **Clave (Key)**     | Identificador interno de la configuración (ej: `site_title`). Buscable y ordenable.  |
| **Nombre mostrado** | Nombre descriptivo legible de la configuración (ej: «Título del sitio»).             |
| **Valor**           | Valor actual de la configuración, truncado a 50 caracteres en el listado.            |
| **Grupo**           | Categoría a la que pertenece la configuración. Ordenable.                            |

> El listado está ordenado por defecto por **Grupo**, facilitando la visualización por categorías.

### Acciones

- **Editar**: Haz clic en el icono de lápiz para editar la configuración.

---

## Crear una nueva configuración

1. Haz clic en el botón **Crear** en la esquina superior derecha.
2. Completa el formulario.

---

## Formulario de configuración

| Campo                | Tipo             | Obligatorio | Descripción                                                                                                      |
|----------------------|------------------|-------------|------------------------------------------------------------------------------------------------------------------|
| **Clave (Key)**      | Texto            | ✅ Sí       | Identificador interno único para esta configuración. Se usa en el código para acceder al valor (ej: `site_title`, `contact_email`, `facebook_url`). Debe ser único. **Convención:** usar snake_case (minúsculas separadas por guiones bajos). Una vez creada, se recomienda no cambiar la clave para evitar errores en el frontend. |
| **Nombre mostrado (Display Name)** | Texto | ✅ Sí  | Nombre descriptivo y legible de la configuración. Se muestra en el listado para identificarla fácilmente (ej: «Título del sitio», «Email de contacto», «URL de Facebook»). |
| **Valor (Value)**    | Texto multilínea | ❌ No       | Valor actual de la configuración. Puede ser texto, una URL, un email, un número, etc., dependiendo del propósito de la configuración. Este es el dato que se utiliza en el frontend. |
| **Detalles (Details)** | Texto multilínea | ❌ No    | Descripción interna sobre para qué sirve esta configuración. Solo visible para administradores. Úsalo para documentar el propósito (ej: «Se muestra en el pie de página del sitio»). |
| **Tipo (Type)**      | Desplegable      | ❌ No       | Tipo de dato del valor. Opciones: **Texto**, **Área de texto** (para textos largos), **Imagen** (para rutas de imagen), **Número**. Por defecto: Texto. Este campo es informativo y ayuda a documentar qué tipo de dato se espera en el valor. |
| **Orden (Order)**    | Número           | ❌ No       | Posición dentro de su grupo. Los números menores aparecen primero. Por defecto: 0.                                |
| **Grupo (Group)**    | Texto            | ❌ No       | Categoría a la que pertenece la configuración. Por defecto: `general`. Valores predefinidos: ver tabla de grupos más abajo. |

---

## Grupos de configuración predefinidos

| Grupo         | Descripción                                                                                  | Ejemplo de claves                                         |
|---------------|----------------------------------------------------------------------------------------------|-----------------------------------------------------------|
| **general**   | Ajustes generales del sitio web.                                                              | `site_title`, `site_description`, `site_logo`             |
| **contact**   | Datos de contacto de la empresa.                                                              | `contact_email`, `contact_phone`, `contact_address`       |
| **social**    | URLs de redes sociales.                                                                       | `facebook_url`, `twitter_url`, `instagram_url`, `linkedin_url` |
| **seo**       | Configuración SEO por defecto.                                                                | `default_meta_keywords`, `default_meta_description`       |

Puedes crear nuevos grupos escribiendo un nombre diferente en el campo «Grupo».

---

## Configuraciones predefinidas del sistema

El sistema viene con las siguientes configuraciones precargadas:

| Clave                      | Grupo    | Descripción                                                          |
|----------------------------|----------|----------------------------------------------------------------------|
| `site_title`               | general  | Nombre del sitio web. Se muestra en la barra de título del navegador, cabecera y pie de página. |
| `site_description`         | general  | Descripción general del sitio. Se usa como meta descripción por defecto en el SEO. |
| `site_logo`                | general  | Ruta de la imagen del logotipo del sitio.                            |
| `contact_email`            | contact  | Email de contacto principal. Se usa en el pie de página y formulario de contacto. |
| `contact_phone`            | contact  | Teléfono de contacto.                                                |
| `contact_address`          | contact  | Dirección postal del negocio.                                        |
| `facebook_url`             | social   | URL del perfil de Facebook. Se muestra en el pie de página.          |
| `twitter_url`              | social   | URL del perfil de Twitter/X. Se usa en el pie de página y meta tags. |
| `instagram_url`            | social   | URL del perfil de Instagram.                                         |
| `linkedin_url`             | social   | URL del perfil de LinkedIn.                                          |
| `default_meta_keywords`    | seo      | Palabras clave SEO por defecto para páginas sin keywords propios.    |
| `default_meta_description` | seo      | Meta descripción por defecto para páginas sin descripción propia.    |

---

## Editar una configuración existente

1. En el listado, haz clic en **Editar** en la fila de la configuración.
2. Modifica el **Valor** (u otros campos si es necesario).
3. Haz clic en **Guardar cambios**.

### Limpieza automática de caché

Al guardar o actualizar cualquier configuración, el sistema **limpia automáticamente la caché** de configuraciones. Esto garantiza que los nuevos valores se reflejen inmediatamente en todo el sitio web, sin necesidad de esperar a que expire la caché.

---

## Cómo se usan las configuraciones en el frontend

Las configuraciones se acceden desde cualquier parte del frontend mediante el helper global `setting()`:

Ejemplo conceptual:
- El título del sitio se lee con `setting('site_title')`.
- Si una clave no existe, se puede proporcionar un valor por defecto.

Los lugares donde se usan las configuraciones incluyen:

| Ubicación            | Configuraciones utilizadas                                          |
|----------------------|---------------------------------------------------------------------|
| **Barra de título**  | `site_title`                                                        |
| **Meta tags SEO**    | `site_title`, `site_description`, `default_meta_keywords`, `twitter_url` |
| **Cabecera (navbar)**| `site_logo`, `site_title`                                           |
| **Pie de página**    | `site_title`, `facebook_url`, `twitter_url`, `instagram_url`, `linkedin_url` |
| **Contacto**         | `contact_email`, `contact_phone`, `contact_address`                 |
| **Emails**           | `site_title` (encabezado del email)                                 |

---

## Preguntas frecuentes

**¿Cuánto tiempo tarda en reflejarse un cambio de configuración?**
Los cambios se reflejan inmediatamente, ya que la caché se limpia automáticamente al guardar.

**¿Puedo crear configuraciones personalizadas?**
Sí, puedes crear cualquier configuración con la clave que desees. Sin embargo, para que se utilice en el frontend, el equipo de desarrollo debe implementar la lectura de esa clave en el código correspondiente.

**¿Qué pasa si elimino una configuración que se usa en el frontend?**
Se mostrará el valor por defecto definido en el código (normalmente vacío o el nombre de la aplicación en Laravel). Se recomienda no eliminar configuraciones del sistema.

**¿Puedo cambiar la clave de una configuración existente?**
Técnicamente sí, pero no es recomendable. Si cambias la clave, el frontend dejará de encontrar esa configuración con la clave antigua y usará el valor por defecto.

**¿Las configuraciones afectan al panel de administración?**
No directamente. Las configuraciones afectan principalmente al frontend público y a los emails. El panel de administración tiene su propia configuración interna.
