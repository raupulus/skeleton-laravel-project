# Fase 10 — Servicios auxiliares

## Resumen
En esta fase se crearán los Mailables, se configurará Scribe para documentación API y se configurarán las notificaciones Filament.

**Dependencias**: Fases 01-09 completadas.

---

## Paso 10.1 — Mailables

### `ContactMail`

Archivo: `app/Mail/ContactMail.php`

```php
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Email enviado cuando un usuario rellena el formulario de contacto.
 */
class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public array $data
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo mensaje de contacto: ' . ($this->data['subject'] ?? ''),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.contact',
            with: ['data' => $this->data],
        );
    }
}
```

### `WelcomeMail`

Archivo: `app/Mail/WelcomeMail.php`

```php
<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Email de bienvenida enviado tras el registro de un nuevo usuario.
 */
class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bienvenido a ' . setting('site_title', config('app.name')),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.welcome',
            with: ['user' => $this->user],
        );
    }
}
```

### `GenericMail`

Archivo: `app/Mail/GenericMail.php`

```php
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Email genérico reutilizable con título y contenido dinámico.
 */
class GenericMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $mailSubject,
        public string $mailContent,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.generic',
            with: [
                'mailSubject' => $this->mailSubject,
                'mailContent' => $this->mailContent,
            ],
        );
    }
}
```

---

## Paso 10.2 — Enviar email de bienvenida en el registro

Modificar el `AuthController::register()` (API) y el controlador de registro de Breeze (web) para enviar email de bienvenida tras crear el usuario:

```php
// Después de crear el usuario:
app(EmailService::class)->send(
    new WelcomeMail($user),
    $user->email,
    'Bienvenido a ' . setting('site_title', config('app.name'))
);
```

---

## Paso 10.3 — Configurar Scribe para documentación API

El archivo `config/scribe.php` ya se creó en la Fase 01. Verificar configuración y generar la documentación:

```bash
php artisan scribe:generate
```

La documentación se genera en `public/docs/api/index.html`.

Añadir anotaciones PHPDoc en los controladores API:
- `@group` para agrupar endpoints
- `@authenticated` / `@unauthenticated` para indicar autenticación
- `@queryParam`, `@bodyParam`, `@urlParam` para documentar parámetros
- `@response` y `@responseFile` para documentar respuestas

Estas anotaciones ya se añadieron en los controladores de la Fase 07.

---

## Paso 10.4 — Notificaciones Filament nativas

Filament genera automáticamente notificaciones toast para acciones CRUD (crear, actualizar, eliminar). No se necesita configuración adicional.

Para personalizar mensajes, en cada Resource se pueden definir:

```php
protected static function getCreatedNotificationTitle(): ?string
{
    return 'Registro creado correctamente';
}

protected static function getUpdatedNotificationTitle(): ?string
{
    return 'Registro actualizado correctamente';
}

protected static function getDeletedNotificationTitle(): ?string
{
    return 'Registro eliminado correctamente';
}
```

---

## Checklist de verificación

- [ ] `ContactMail` creado con vista `mail.contact`
- [ ] `WelcomeMail` creado con vista `mail.welcome`
- [ ] `GenericMail` creado con vista `mail.generic` y parámetros dinámicos
- [ ] Email de bienvenida integrado en registro API y web
- [ ] Todos los emails se envían vía `EmailService` (registrados en `sent_emails`)
- [ ] `php artisan scribe:generate` ejecutado, documentación accesible en `/docs/api`
- [ ] Controladores API anotados con PHPDoc para Scribe
- [ ] Notificaciones Filament configuradas con mensajes en español
