<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

/**
 * Regla de validación para Google reCAPTCHA v3.
 * Si las claves no están definidas en el archivo .env, se omite automáticamente
 * la verificación para permitir entornos de desarrollo y pruebas continuas.
 */
class Recaptcha implements ValidationRule
{
    /**
     * Indica que la regla debe evaluarse aunque el atributo no esté presente o esté vacío.
     */
    public bool $implicit = true;

    /**
     * Acción esperada para la validación de reCAPTCHA v3 (opcional).
     */
    protected ?string $action;

    /**
     * Constructor de la regla.
     *
     * @param  string|null  $action  Acción del formulario (ej: 'contact', 'login')
     */
    public function __construct(?string $action = null)
    {
        $this->action = $action;
    }

    /**
     * Ejecuta la validación de reCAPTCHA.
     *
     * @param  string  $attribute  Nombre del atributo validado
     * @param  mixed  $value  Token de respuesta de reCAPTCHA
     * @param  Closure  $fail  Callback de fallo de validación
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $siteKey = config('services.recaptcha.site_key');
        $secretKey = config('services.recaptcha.secret_key');

        // Si alguna de las claves no está configurada en .env, omitir la validación (desarrollo / tests)
        if (empty($siteKey) || empty($secretKey)) {
            return;
        }

        // Si las claves existen pero el token está vacío
        if (empty($value) || ! is_string($value)) {
            $fail(__('messages.validation_recaptcha_required'));

            return;
        }

        try {
            $response = Http::asForm()->timeout(5)->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);

            if (! $response->successful()) {
                $fail(__('messages.validation_recaptcha_failed'));

                return;
            }

            $data = $response->json();
            $minScore = (float) config('services.recaptcha.min_score', 0.5);
            $actionMismatch = $this->action !== null
                && isset($data['action'])
                && $data['action'] !== $this->action;

            if (! ($data['success'] ?? false) || (($data['score'] ?? 0.0) < $minScore) || $actionMismatch) {
                $fail(__('messages.validation_recaptcha_failed'));
            }
        } catch (\Throwable) {
            // En caso de fallo de conexión con la API de Google, no bloquear la acción del usuario
            // salvo en producción
            if (app()->isProduction()) {
                $fail(__('messages.validation_recaptcha_failed'));
            }
        }
    }
}
