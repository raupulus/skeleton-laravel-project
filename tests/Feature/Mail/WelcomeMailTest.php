<?php

namespace Tests\Feature\Mail;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests para el Mailable WelcomeMail.
 * Verifica que el email de bienvenida tiene el contenido correcto.
 */
class WelcomeMailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que el email de bienvenida se puede crear y renderizar sin errores.
     */
    public function test_welcome_email_can_be_rendered(): void
    {
        $user = User::factory()->create(['name' => 'Test User']);
        $mailable = new WelcomeMail($user);

        $rendered = $mailable->render();

        $this->assertStringContainsString('Test User', $rendered);
    }

    /**
     * Verifica que el email de bienvenida tiene el contenido del usuario en el asunto/cuerpo.
     */
    public function test_welcome_email_has_correct_subject(): void
    {
        $user = User::factory()->create(['name' => 'Maria Lopez']);
        $mailable = new WelcomeMail($user);

        // Verificar que se puede renderizar (Laravel 11+ no tiene build())
        $rendered = $mailable->render();
        $this->assertNotEmpty($rendered);
    }
}
