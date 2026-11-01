# Manual del Usuario — API REST

*Última actualización: 2026-08-26*

## Descripción

La plataforma ofrece una **API REST** (interfaz de programación) que permite a aplicaciones externas acceder al contenido y funcionalidades del sitio de forma programática. Esto es útil si quieres integrar el contenido de la plataforma en una aplicación móvil, otro sitio web o cualquier herramienta automatizada.

**URL base de la API:** `https://tu-dominio.com/api/v1`

---

## Endpoints públicos (sin autenticación)

Estos endpoints no requieren token de acceso. Cualquier persona o aplicación puede consultarlos:

### Posts (Blog)

| Método | Endpoint              | Descripción                                           |
|--------|-----------------------|-------------------------------------------------------|
| GET    | `/api/v1/posts`       | Listado paginado de todos los posts publicados.       |
| GET    | `/api/v1/posts/{slug}`| Detalle completo de un post por su slug.              |

**Ejemplo:**
```
GET https://tu-dominio.com/api/v1/posts
```
Respuesta: Lista de posts con título, contenido, extracto, categorías, fecha de publicación, etc.

```
GET https://tu-dominio.com/api/v1/posts/mi-primer-articulo
```
Respuesta: Detalle completo del post con slug `mi-primer-articulo`.

---

### Páginas

| Método | Endpoint               | Descripción                                           |
|--------|------------------------|-------------------------------------------------------|
| GET    | `/api/v1/pages`        | Listado paginado de todas las páginas publicadas.     |
| GET    | `/api/v1/pages/{slug}` | Detalle completo de una página por su slug.           |

---

### Categorías

| Método | Endpoint                    | Descripción                                      |
|--------|-----------------------------|--------------------------------------------------|
| GET    | `/api/v1/categories`        | Listado de todas las categorías activas.         |
| GET    | `/api/v1/categories/{slug}` | Detalle de una categoría por su slug.            |

---

## Endpoints de autenticación

Estos endpoints permiten registrarse, iniciar sesión y gestionar la autenticación desde aplicaciones externas:

### Registro

| Método | Endpoint                  | Descripción                                           |
|--------|---------------------------|-------------------------------------------------------|
| POST   | `/api/v1/auth/register`   | Crear una nueva cuenta de usuario.                    |

**Campos requeridos:**
- `name` — Nombre del usuario.
- `email` — Email (debe ser único).
- `password` — Contraseña (mínimo 8 caracteres).
- `password_confirmation` — Confirmación de la contraseña.

**Respuesta exitosa:** Datos del usuario creado + token de acceso.

---

### Inicio de sesión

| Método | Endpoint               | Descripción                                           |
|--------|------------------------|-------------------------------------------------------|
| POST   | `/api/v1/auth/login`   | Iniciar sesión y obtener un token de acceso.          |

**Campos requeridos:**
- `email` — Email registrado.
- `password` — Contraseña.

**Respuesta exitosa:** Datos del usuario + token de acceso.

---

### Recuperación de contraseña

| Método | Endpoint                         | Descripción                                          |
|--------|----------------------------------|------------------------------------------------------|
| POST   | `/api/v1/auth/forgot-password`   | Solicitar un enlace de restablecimiento de contraseña.|
| POST   | `/api/v1/auth/reset-password`    | Restablecer la contraseña con el token recibido.     |

**Forgot password — campos requeridos:**
- `email` — Email de la cuenta.

**Reset password — campos requeridos:**
- `email` — Email de la cuenta.
- `token` — Token recibido en el email de restablecimiento.
- `password` — Nueva contraseña.
- `password_confirmation` — Confirmación de la nueva contraseña.

---

## Endpoints autenticados (requieren token)

Estos endpoints requieren que envíes un **token de acceso** en la cabecera de la petición:

```
Authorization: Bearer tu-token-aqui
```

Puedes obtener un token al iniciar sesión (`/api/v1/auth/login`) o creando uno desde el [Panel de Usuario → Tokens API](../user_backend/03-tokens-api.md).

### Datos del usuario

| Método | Endpoint               | Descripción                              |
|--------|------------------------|------------------------------------------|
| GET    | `/api/v1/auth/user`    | Obtener los datos de tu perfil.          |
| POST   | `/api/v1/auth/logout`  | Cerrar sesión (revoca el token actual).  |

---

### Gestión de tokens API

| Método | Endpoint                        | Descripción                                    |
|--------|---------------------------------|------------------------------------------------|
| GET    | `/api/v1/user/tokens`           | Listar todos tus tokens activos.               |
| POST   | `/api/v1/user/tokens`           | Crear un nuevo token (campo: `name`).          |
| DELETE | `/api/v1/user/tokens/{id}`      | Eliminar (revocar) un token por su ID.         |

---

## Formato de las respuestas

Todas las respuestas de la API están en formato **JSON**. Ejemplo de respuesta exitosa:

```json
{
    "message": "Inicio de sesión exitoso.",
    "user": {
        "id": 1,
        "name": "Juan Pérez",
        "email": "juan@ejemplo.com",
        "role": "user"
    },
    "token": "1|abcdef123456789..."
}
```

Ejemplo de respuesta de error:

```json
{
    "message": "Las credenciales no coinciden.",
    "errors": {
        "email": ["Las credenciales proporcionadas son incorrectas."]
    }
}
```

---

## Códigos de estado HTTP

| Código | Significado                                              |
|--------|----------------------------------------------------------|
| 200    | Petición exitosa.                                        |
| 201    | Recurso creado correctamente (ej: registro, nuevo token).|
| 401    | No autenticado (token inválido o no proporcionado).      |
| 403    | Prohibido (cuenta desactivada o sin permisos).           |
| 404    | Recurso no encontrado.                                   |
| 422    | Error de validación (campos incorrectos o faltantes).    |
| 500    | Error interno del servidor.                              |

---

## Documentación técnica completa

La plataforma incluye una **documentación API completa** generada automáticamente con Scribe, accesible desde:

```
https://tu-dominio.com/docs
```

Esta documentación incluye todos los endpoints con ejemplos de petición y respuesta, parámetros, cabeceras y más.

---

## Preguntas frecuentes

**¿Necesito un token para consultar posts, páginas o categorías?**
No, los endpoints de contenido público no requieren autenticación.

**¿Los tokens caducan?**
No, los tokens son válidos hasta que los elimines manualmente.

**¿Puedo usar la API desde cualquier dominio?**
La API es accesible desde cualquier origen. Las peticiones desde aplicaciones web externas (CORS) están permitidas según la configuración del servidor.

**¿Qué pasa si mi token es revocado?**
Recibirás un error 401 (No autenticado) en todas las peticiones que requieran autenticación. Deberás iniciar sesión de nuevo o crear un nuevo token.
