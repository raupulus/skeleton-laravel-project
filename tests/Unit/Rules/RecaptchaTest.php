<?php

namespace Tests\Unit\Rules;

use App\Rules\Recaptcha;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * Tests para la regla de validación de Google reCAPTCHA v3.
 */
class RecaptchaTest extends TestCase
{
    /**
     * Comprueba que la validación se omite cuando no hay clave secreta en la configuración.
     */
    public function test_recaptcha_passes_when_secret_key_is_missing(): void
    {
        config(['services.recaptcha.secret_key' => null]);

        $failed = false;
        $failCallback = function () use (&$failed) {
            $failed = true;
        };

        $rule = new Recaptcha('contact');
        $rule->validate('g-recaptcha-response', null, $failCallback);

        $this->assertFalse($failed, 'La regla debería pasar automáticamente si la clave no está configurada.');
    }

    /**
     * Comprueba que la validación falla si hay clave pero el token es inválido según Google.
     */
    public function test_recaptcha_fails_when_token_is_invalid(): void
    {
        config([
            'services.recaptcha.site_key' => 'test-site-key',
            'services.recaptcha.secret_key' => 'test-secret-key',
        ]);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => false,
                'error-codes' => ['invalid-input-response'],
            ], 200),
        ]);

        $failed = false;
        $failCallback = function () use (&$failed) {
            $failed = true;
        };

        $rule = new Recaptcha('contact');
        $rule->validate('g-recaptcha-response', 'invalid-token', $failCallback);

        $this->assertTrue($failed, 'La regla debería fallar cuando Google devuelve success = false.');
    }

    /**
     * Comprueba que la validación pasa cuando Google devuelve éxito con puntuación suficiente.
     */
    public function test_recaptcha_passes_when_google_verifies_successfully(): void
    {
        config([
            'services.recaptcha.site_key' => 'test-site-key',
            'services.recaptcha.secret_key' => 'test-secret-key',
            'services.recaptcha.min_score' => 0.5,
        ]);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
                'score' => 0.9,
                'action' => 'contact',
            ], 200),
        ]);

        $failed = false;
        $failCallback = function () use (&$failed) {
            $failed = true;
        };

        $rule = new Recaptcha('contact');
        $rule->validate('g-recaptcha-response', 'valid-token', $failCallback);

        $this->assertFalse($failed, 'La regla debería pasar cuando Google valida con éxito.');
    }

    /**
     * Comprueba que la validación falla si la acción devuelta por Google no coincide con la esperada.
     */
    public function test_recaptcha_fails_when_action_does_not_match(): void
    {
        config([
            'services.recaptcha.site_key' => 'test-site-key',
            'services.recaptcha.secret_key' => 'test-secret-key',
            'services.recaptcha.min_score' => 0.5,
        ]);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
                'score' => 0.9,
                'action' => 'login',
            ], 200),
        ]);

        $failed = false;
        $failCallback = function () use (&$failed) {
            $failed = true;
        };

        $rule = new Recaptcha('contact');
        $rule->validate('g-recaptcha-response', 'valid-token', $failCallback);

        $this->assertTrue($failed, 'La regla debería fallar si la acción no coincide.');
    }
}
