# Módulo: Emails Enviados

> Registro automático de auditoría de todos los emails enviados por la plataforma, con estados y visualización completa desde el backend.

---

## Resumen

Cada email que la plataforma envía (bienvenida, contacto, genéricos) se registra automáticamente en la tabla `sent_emails`. El módulo es de solo lectura en el panel admin y permite consultar el historial completo con destinatario, asunto, cuerpo HTML, estado (sent/failed) y posibles errores.

---

## Archivos principales

| Tipo | Ruta |
|------|------|
| Modelo | `app/Models/SentEmail.php` |
| Enum de estados | `app/Enums/EmailStatus.php` |
| Filament Resource | `app/Filament/Admin/Resources/SentEmailResource.php` |
| Policy | `app/Policies/SentEmailPolicy.php` |
| Migración | `database/migrations/*_create_sent_emails_table.php` |

---

## Campos del modelo

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | int (PK) | Identificador único |
| `to` | string | Email del destinatario |
| `from` | string (nullable) | Email del remitente |
| `subject` | string | Asunto del email |
| `body` | text | Cuerpo HTML completo del email tal como se envió |
| `mailable_class` | string | Clase PHP del Mailable usado (ej: `App\Mail\ContactMail`) |
| `status` | enum (EmailStatus) | `sent` o `failed` |
| `error_message` | text (nullable) | Mensaje de error si el envío falló |
| `metadata` | json (nullable) | Datos adicionales opcionales |
| `created_at` | datetime | Fecha/hora del intento de envío |

---

## Estados (Enum `App\Enums\EmailStatus`)

| Valor | Label | Color Filament |
|-------|-------|----------------|
| `sent` | Enviado | success (verde) |
| `failed` | Fallido | danger (rojo) |

---

## Scopes

| Scope | Descripción |
|-------|-------------|
| `sent()` | Solo emails con estado `sent` |
| `failed()` | Solo emails con estado `failed` |

---

## Panel Admin (Filament)

- **Grupo de navegación**: Sistema
- **Icono**: `heroicon-o-envelope`
- **Labels**: «Email enviado» / «Emails enviados»
- **Solo lectura**: `canCreate()` devuelve `false`. No se pueden crear, editar ni eliminar
- **Listado**: to (buscable), subject (buscable, truncado 50), mailable_class (truncado 30), status (badge), created_at. Ordenado por fecha desc.
- **Acción**: ViewAction para ver el detalle completo (body HTML) en modal

---

## Policy

Solo administradores pueden verlos. No se permite crear, editar ni eliminar desde ningún rol.
