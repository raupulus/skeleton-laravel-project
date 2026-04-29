# Manual del Administrador — Gestión de Usuarios

## Objetivo

El módulo de **Usuarios** permite gestionar todas las cuentas de la plataforma. Desde aquí puedes crear nuevos usuarios, editar sus datos, asignar roles, activar o desactivar cuentas y eliminar usuarios. Este módulo se encuentra en el grupo **Sistema** del menú lateral.

---

## Acceder al módulo

1. En el menú lateral, haz clic en el grupo **Sistema**.
2. Selecciona **Usuarios**.
3. Verás el listado de todos los usuarios registrados en la plataforma.

---

## Listado de usuarios

El listado muestra una tabla con todos los usuarios del sistema. Las columnas disponibles son:

| Columna          | Descripción                                                                                      |
|------------------|--------------------------------------------------------------------------------------------------|
| **Nombre**       | Nombre completo del usuario. Es buscable y ordenable haciendo clic en el encabezado.             |
| **Email**        | Dirección de correo electrónico del usuario. Es buscable y ordenable.                            |
| **Rol**          | Rol asignado al usuario, mostrado como una etiqueta de color: `superadmin` y `admin` en color primario, `user` en gris. |
| **Activo**       | Icono que indica si la cuenta está activa (✓ verde) o desactivada (✗ rojo).                      |
| **Fecha de creación** | Fecha en que se creó la cuenta, mostrada en formato `dd/mm/aaaa`. Ordenable.               |

### Búsqueda

Utiliza el campo de búsqueda en la parte superior de la tabla para buscar usuarios por **nombre** o **email**. Escribe al menos 2-3 caracteres y los resultados se filtrarán automáticamente.

### Filtros disponibles

En la parte superior de la tabla encontrarás los siguientes filtros:

| Filtro       | Tipo         | Descripción                                                          |
|--------------|--------------|----------------------------------------------------------------------|
| **Rol**      | Desplegable  | Filtra usuarios por rol: Superadmin, Admin o Usuario.                |
| **Activo**   | Ternario     | Tres opciones: Todos, Solo activos, Solo inactivos.                  |

> **Consejo:** Puedes combinar filtros y búsqueda simultáneamente para refinar los resultados.

### Acciones

- **Editar**: Haz clic en el botón de edición (icono de lápiz) en la fila del usuario para modificar sus datos.
- **Eliminar en lote**: Marca las casillas de los usuarios que deseas eliminar y selecciona la acción **Eliminar seleccionados** en la barra de acciones masivas.

> **Importante:** No puedes eliminarte a ti mismo. El sistema lo impide para evitar que un administrador bloquee su propio acceso.

---

## Crear un nuevo usuario

1. En el listado de usuarios, haz clic en el botón **Crear** (esquina superior derecha).
2. Completa el formulario con los siguientes campos:

### Campos del formulario

| Campo           | Tipo             | Obligatorio | Descripción                                                                                                           |
|-----------------|------------------|-------------|-----------------------------------------------------------------------------------------------------------------------|
| **Nombre**      | Texto            | ✅ Sí       | Nombre completo del usuario. Máximo 255 caracteres.                                                                   |
| **Email**       | Texto (email)    | ✅ Sí       | Dirección de correo electrónico. Debe ser única en el sistema. Se usa para el inicio de sesión.                       |
| **Contraseña**  | Contraseña       | ✅ Sí (al crear) | Contraseña del usuario. Mínimo 8 caracteres. Se almacena de forma encriptada. Al editar, solo rellénalo si quieres cambiar la contraseña; si lo dejas vacío, se mantiene la actual. |
| **Rol**         | Desplegable      | ✅ Sí       | Rol del usuario en la plataforma. Opciones disponibles: ver tabla de roles más abajo.                                 |
| **Avatar**      | Subida de imagen | ❌ No       | Foto de perfil del usuario. Se aceptan formatos de imagen (JPG, PNG, etc.). Se almacena en la carpeta `avatars`.      |
| **Activo**      | Interruptor      | ❌ No       | Indica si la cuenta está activa. Por defecto está activado. Si se desactiva, el usuario no podrá iniciar sesión ni acceder a ningún panel. |

### Roles disponibles

| Rol            | Descripción                                                                                                  |
|----------------|--------------------------------------------------------------------------------------------------------------|
| **Superadmin** | Acceso total al panel de administración. Puede gestionar todos los recursos del sistema sin restricciones.    |
| **Admin**      | Acceso completo al panel de administración. Mismos permisos que superadmin dentro del backoffice.             |
| **User**       | Usuario estándar. Solo puede acceder al panel de usuario (`/panel`) para gestionar su perfil y tokens API. No tiene acceso al panel de administración. |

3. Haz clic en **Crear** para guardar el nuevo usuario.

---

## Editar un usuario existente

1. En el listado de usuarios, haz clic en el botón **Editar** (icono de lápiz) de la fila correspondiente.
2. Modifica los campos necesarios. El campo **contraseña** se muestra vacío: solo rellénalo si deseas cambiarla.
3. Haz clic en **Guardar cambios**.

### Notas sobre la edición

- El **email** debe seguir siendo único. Si introduces un email que ya existe en otra cuenta, se mostrará un error de validación.
- Si cambias el **rol** de un usuario de `admin` a `user`, este perderá inmediatamente el acceso al panel de administración.
- Si **desactivas** la cuenta de un usuario, se cerrará su sesión actual y no podrá volver a iniciar sesión hasta que la reactives.

---

## Eliminar usuarios

### Eliminación individual
No hay botón de eliminación individual directamente en la fila. Para eliminar un usuario específico, márcalo con la casilla de la izquierda y usa la acción en lote.

### Eliminación en lote
1. Marca las casillas de los usuarios que quieras eliminar.
2. Haz clic en el botón **Eliminar seleccionados** que aparece en la barra superior.
3. Confirma la eliminación en el diálogo de confirmación.

> **⚠️ Precauciones:**
> - No puedes eliminar tu propia cuenta.
> - La eliminación utiliza **borrado lógico (soft delete)**, lo que significa que los datos del usuario se marcan como eliminados pero no se borran permanentemente de la base de datos.
> - El contenido creado por un usuario eliminado (posts, páginas) conserva la referencia al autor original.

---

## Preguntas frecuentes

**¿Qué ocurre si desactivo un usuario que está conectado?**
El usuario podrá seguir navegando hasta que su sesión expire, pero no podrá volver a iniciar sesión. Se recomienda comunicar al usuario antes de desactivar su cuenta.

**¿Puedo tener más de un superadmin?**
Sí, puedes asignar el rol de `superadmin` a múltiples usuarios. Sin embargo, se recomienda limitar este rol a las personas estrictamente necesarias.

**¿Un usuario puede cambiar su propio rol?**
No. Solo los administradores desde el panel de administración pueden cambiar el rol de un usuario.

**¿Qué pasa con los tokens API de un usuario eliminado?**
Los tokens API asociados al usuario se invalidan automáticamente al eliminarse la cuenta.
