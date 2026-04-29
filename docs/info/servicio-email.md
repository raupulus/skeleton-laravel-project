# Módulo: EmailService

> Servicio centralizado para el envío de emails que registra automáticamente cada intento en la tabla `sent_emails` para auditoría.

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
