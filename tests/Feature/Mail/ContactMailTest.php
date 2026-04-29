<?php

namespace Tests\Feature\Mail;

use App\Mail\ContactMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests para el Mailable ContactMail.
 * Verifica que el email de contacto tiene el contenido correcto.
 */
class ContactMailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que el email de contacto se puede renderizar con los datos del formulario.
     */
    public function test_contact_email_can_be_rendered(): void
    {
        $data = [
            'name'    => 'Juan García',
            'email'   => 'juan@example.com',
            'subject' => 'Consulta sobre precios',
            'message' => 'Me gustaría saber más sobre vuestros servicios.',
        ];

        $mailable = new ContactMail($data);
        $rendered = $mailable->render();

        $this->assertStringContainsString('Juan García', $rendered);
        $this->assertStringContainsString('Consulta sobre precios', $rendered);
    }
}
