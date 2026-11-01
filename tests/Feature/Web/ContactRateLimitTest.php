<?php

namespace Tests\Feature\Web;

use Tests\TestCase;

class ContactRateLimitTest extends TestCase
{
    public function test_contact_form_rate_limiting_triggers_after_excessive_attempts(): void
    {
        $payload = [
            'name' => 'Spam Bot',
            'email' => 'spam@example.com',
            'subject' => 'Consulta',
            'message' => 'Mensaje de prueba para rate limiting',
            'privacy' => true,
        ];

        // Realizar 10 peticiones permitidas
        for ($i = 0; $i < 10; $i++) {
            $response = $this->post(route('contact.send'), $payload);
            $this->assertNotEquals(429, $response->status());
        }

        // La 11ª petición dentro del mismo minuto debe recibir 429 Too Many Requests
        $response = $this->post(route('contact.send'), $payload);
        $response->assertStatus(429);
    }
}
