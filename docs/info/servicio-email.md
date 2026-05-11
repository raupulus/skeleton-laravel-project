# Módulo: EmailService

> Servicio centralizado para el envío de emails que registra automáticamente cada intento en la tabla `sent_emails` para auditoría.

---

## Objetivo y funcionalidad

El `EmailService` es el punto único y centralizado de envío de emails de toda la plataforma. Su objetivo es garantizar que ningún email se envíe sin quedar registrado, proporcionando trazabilidad completa de todas las comunicaciones salientes.

El servicio acepta cualquier `Mailable` de Laravel, lo renderiza a HTML, lo envía al destinatario y crea un registro en la tabla `sent_emails` con el cuerpo completo, destinatario, asunto y estado del envío. Si el envío falla por cualquier motivo (error de SMTP, configuración incorrecta, etc.), el error se captura, se registra en el campo `error_message` y el registro se marca como `failed`, pero **la excepción no se relanza**, evitando interrumpir el flujo del usuario.

Todos los puntos de la aplicación que necesiten enviar emails deben hacerlo a través de este servicio en lugar de usar `Mail::send()` directamente. Esto incluye el registro de usuarios (email de bienvenida), el formulario de contacto y cualquier notificación futura. El servicio se integra con el módulo de emails enviados para que los administradores puedan auditar el historial desde el panel admin.

---

## Resumen

El `EmailService` es el punto único de envío de emails de la plataforma. Acepta cualquier `Mailable` de Laravel, lo envía y crea un registro en `sent_emails` con el cuerpo HTML, destinatario, asunto y estado. Si el envío falla, captura la excepción, marca el registro como `failed` con el mensaje de error, pero **no relanza la excepción** para no interrumpir el flujo del usuario.

---

## Archivo

`app/Services/EmailService.php`

---

## API del servicio

### `send(Mailable $mailable, string $to, string $subject): SentEmail`

Envía un email y lo registra en la base de datos.

**Parámetros:**
- `$mailable` — Objeto Mailable con el contenido del email
- `$to` — Dirección email del destinatario
- `$subject` — Asunto para el registro en `sent_emails`

**Retorno:** El modelo `SentEmail` creado (con estado `sent` o `failed`).

**Flujo interno:**
1. Intenta renderizar el Mailable a HTML (`$mailable->render()`)
2. Si el render falla → crea registro con `status=failed` y retorna
3. Crea el registro `SentEmail` con `status=sent`
4. Intenta enviar el email vía `Mail::to($to)->send($mailable)`
5. Si el envío falla → actualiza el registro a `status=failed` con `error_message`

---

## Mailables disponibles

| Mailable | Archivo | Cuándo se envía | Vista |
|----------|---------|-----------------|-------|
| `WelcomeMail` | `app/Mail/WelcomeMail.php` | Al registrarse un usuario | `resources/views/mail/welcome.blade.php` |
| `ContactMail` | `app/Mail/ContactMail.php` | Al enviar el formulario de contacto | `resources/views/mail/contact.blade.php` |
| `GenericMail` | `app/Mail/GenericMail.php` | Emails personalizados con contenido dinámico | `resources/views/mail/generic.blade.php` |

---

## Ejemplo de uso

```php
use App\Mail\ContactMail;
use App\Services\EmailService;

$emailService = app(EmailService::class);
$emailService->send(
    new ContactMail($data),
    setting('contact_email', 'admin@example.com'),
    'Contacto: ' . $data['subject']
);
```

---

## Layout de emails

Todos los emails usan un layout base en `resources/views/mail/layouts/base.blade.php` con estilos inline, header con el nombre del sitio y footer con copyright.
