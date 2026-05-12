<?php

namespace Tests\Feature\Web;

use Tests\TestCase;

/**
 * Tests para verificar que la página de contacto está correctamente traducida.
 */
class ContactTranslationTest extends TestCase
{
    /**
     * Verifica que la página de contacto renderiza en español por defecto.
     */
    public function test_contact_page_renders_in_spanish(): void
    {
        $response = $this->get(route('contact'));
        $response->assertStatus(200);
        $response->assertSee(__('messages.contact'));
        $response->assertSee(__('messages.contact_name'));
        $response->assertSee(__('messages.contact_send'));
    }

    /**
     * Verifica que los mensajes de validación del formulario de contacto están traducidos.
     */
    public function test_contact_validation_messages_are_translated(): void
    {
        $response = $this->post(route('contact.send'), []);
        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }
}
