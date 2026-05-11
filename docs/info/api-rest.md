# Módulo: API REST

> API RESTful versionada en `/api/v1` con endpoints públicos para contenido, autenticación vía Sanctum, gestión de tokens y documentación automática con Scribe.

---

## Objetivo y funcionalidad

La API REST permite que aplicaciones externas (apps móviles, SPAs, integraciones de terceros, automatizaciones) interactúen con la plataforma de forma programática. Su objetivo es exponer el contenido público y las funcionalidades de autenticación mediante una interfaz HTTP estándar, versionada y documentada.

La API se estructura en tres grupos:

1. **Endpoints públicos** (sin autenticación): permiten consultar posts, páginas y categorías publicados. Útil para consumir el contenido del sitio desde aplicaciones frontend independientes o servicios de terceros.

2. **Endpoints de autenticación** (sin token): permiten registrar usuarios, iniciar sesión (obteniendo un token Bearer), solicitar restablecimiento de contraseña y completar el reset. El token obtenido se usa para los endpoints autenticados.

3. **Endpoints autenticados** (Bearer token): permiten consultar los datos del usuario autenticado, cerrar sesión (revocar token) y gestionar tokens API personales (crear, listar, eliminar).

Los endpoints de autenticación tienen rate limiting para prevenir ataques de fuerza bruta. Las respuestas de usuario se filtran mediante `UserResource` para no exponer datos sensibles. La documentación se genera automáticamente con Scribe y es accesible en `/docs`.

---

## Resumen

La API REST permite a aplicaciones externas acceder al contenido (posts, páginas, categorías) sin autenticación, y gestionar la cuenta (registro, login, perfil, tokens) con autenticación Bearer token vía Laravel Sanctum. La documentación se genera automáticamente con Scribe y es accesible en `/docs`.

---

## Archivos principales

| Tipo | Ruta |
|------|------|
| Rutas | `routes/api.php` |
| Auth Controller | `app/Http/Controllers/Api/V1/AuthController.php` |
| Token Controller | `app/Http/Controllers/Api/V1/TokenController.php` |
| Post Controller | `app/Http/Controllers/Api/V1/PostApiController.php` |
| Page Controller | `app/Http/Controllers/Api/V1/PageApiController.php` |
| Category Controller | `app/Http/Controllers/Api/V1/CategoryApiController.php` |
| FormRequests | `app/Http/Requests/Api/V1/Auth/` |
| Config Scribe | `config/scribe.php` |

---

## Endpoints

### Públicos (sin autenticación)

| Método | URI | Nombre | Descripción |
|--------|-----|--------|-------------|
| GET | `/api/v1/posts` | `api.v1.posts.index` | Listado paginado de posts publicados |
| GET | `/api/v1/posts/{slug}` | `api.v1.posts.show` | Detalle de un post por slug |
| GET | `/api/v1/pages` | `api.v1.pages.index` | Listado paginado de páginas publicadas |
| GET | `/api/v1/pages/{slug}` | `api.v1.pages.show` | Detalle de una página por slug |
| GET | `/api/v1/categories` | `api.v1.categories.index` | Listado de categorías activas |
| GET | `/api/v1/categories/{slug}` | `api.v1.categories.show` | Detalle de una categoría |

### Autenticación (sin token)

| Método | URI | Nombre | Descripción |
|--------|-----|--------|-------------|
| POST | `/api/v1/auth/register` | `api.v1.auth.register` | Registro + token |
| POST | `/api/v1/auth/login` | `api.v1.auth.login` | Login + token |
| POST | `/api/v1/auth/forgot-password` | `api.v1.auth.forgot-password` | Enviar enlace de reset |
| POST | `/api/v1/auth/reset-password` | `api.v1.auth.reset-password` | Resetear contraseña |

### Autenticados (Bearer token)

| Método | URI | Nombre | Descripción |
|--------|-----|--------|-------------|
| GET | `/api/v1/auth/user` | `api.v1.auth.user` | Datos del usuario autenticado |
| POST | `/api/v1/auth/logout` | `api.v1.auth.logout` | Revocar token actual |
| GET | `/api/v1/user/tokens` | `api.v1.tokens.index` | Listar tokens propios |
| POST | `/api/v1/user/tokens` | `api.v1.tokens.store` | Crear nuevo token |
| DELETE | `/api/v1/user/tokens/{id}` | `api.v1.tokens.destroy` | Eliminar token |

---

## Autenticación

Mediante la cabecera `Authorization: Bearer {token}`. Los tokens se generan con Sanctum al hacer login/registro o desde el panel de usuario.

Las respuestas de usuario se filtran mediante `UserResource` para no exponer datos sensibles (role, deleted_at, etc.).

---

## Rate Limiting

Los endpoints de autenticación tienen rate limiting para prevenir ataques de fuerza bruta:

| Endpoint | Límite |
|----------|--------|
| `POST /auth/register` | 5 peticiones/minuto |
| `POST /auth/login` | 10 peticiones/minuto |
| `POST /auth/forgot-password` | 3 peticiones/minuto |
| `POST /auth/reset-password` | 5 peticiones/minuto |

---

## Formato de respuesta

Todas las respuestas son JSON. Ejemplo exitoso:

```json
{
    "message": "Inicio de sesión exitoso.",
    "user": { "id": 1, "name": "Juan", "email": "juan@example.com" },
    "token": "1|abc123..."
}
```

Ejemplo de error de validación (HTTP 422):

```json
{
    "message": "Los datos proporcionados no son válidos.",
    "errors": { "email": ["El campo email es obligatorio."] }
}
```

---

## Documentación Scribe

```bash
php artisan scribe:generate
# Accesible en: /docs
```
