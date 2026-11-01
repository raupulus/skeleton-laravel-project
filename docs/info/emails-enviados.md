# Módulo: Emails Enviados

*Última actualización: 2026-08-26*

> Registro automático de auditoría de todos los emails enviados por la plataforma, con estados y visualización completa desde el backend.

---

## Objetivo y funcionalidad

El módulo de emails enviados proporciona un sistema de auditoría y trazabilidad para todos los correos electrónicos que la plataforma envía. Su objetivo es que los administradores puedan consultar en cualquier momento el historial completo de emails: a quién se envió, con qué asunto, cuál fue el contenido HTML exacto, si se entregó correctamente o falló, y en caso de fallo, cuál fue el error.

Cada vez que el `EmailService` envía un email (bienvenida al registro, formulario de contacto, notificaciones genéricas), se crea automáticamente un registro en la tabla `sent_emails` con toda la información del envío. Este módulo es estrictamente de solo lectura: no se pueden crear, editar ni eliminar registros desde el panel admin, ya que son registros de auditoría generados automáticamente por el sistema.

Desde el panel de administración, los administradores pueden buscar emails por destinatario o asunto, filtrar por estado (enviado/fallido) y ver el cuerpo HTML completo del email tal como se envió al usuario. Esto es especialmente útil para diagnosticar problemas de entrega, verificar que los emails se están generando correctamente y mantener un registro legal de las comunicaciones enviadas.

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
