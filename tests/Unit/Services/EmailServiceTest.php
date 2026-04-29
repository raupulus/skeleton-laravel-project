<?php

namespace Tests\Unit\Services;

use App\Mail\WelcomeMail;
use App\Models\SentEmail;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * Tests para el servicio EmailService.
 * Verifica que los emails se envíen correctamente y se registren en la BD.
 */
class EmailServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que al enviar un email se crea un registro en la tabla sent_emails.
     */
    public function test_email_gets_recorded_in_sent_emails_table(): void
    {
        Mail::fake();
        $user = User::factory()->create();
        $service = app(EmailService::class);

        $sentEmail = $service->send(new WelcomeMail($user), $user->email, 'Bienvenido');

        $this->assertDatabaseHas('sent_emails', [
            'to'             => $user->email,
            'subject'        => 'Bienvenido',
            'mailable_class' => WelcomeMail::class,
            'status'         => 'sent',
        ]);
        $this->assertInstanceOf(SentEmail::class, $sentEmail);
    }

    /**
     * Verifica que un fallo en el envío de email se registra con status=failed.
     * Usamos una dirección inválida para forzar el fallo en entorno de log.
     */
    public function test_failed_email_is_recorded_as_failed_status(): void
    {
        // Configurar mailer que falle deliberadamente
        config(['mail.mailer' => 'array']);

        // Crear un mailable que lanze excepción al renderizar
        $failingMailable = new class(User::factory()->make()) extends \App\Mail\WelcomeMail {
            public function render(): string
            {
                throw new \Exception('Error de renderizado forzado para test');
            }
        };

        $user = User::factory()->create();
        $service = app(EmailService::class);

        $sentEmail = $service->send($failingMailable, $user->email, 'Test');

        $this->assertEquals('failed', $sentEmail->status->value);
        $this->assertNotNull($sentEmail->error_message);
    }
}
