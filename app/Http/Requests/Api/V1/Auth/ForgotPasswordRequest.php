<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * FormRequest para solicitar el restablecimiento de contraseña.
 * Verifica que el email enviado exista en la base de datos.
 */
class ForgotPasswordRequest extends FormRequest
{
    /**
     * Cualquier usuario puede solicitar el restablecimiento de contraseña.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación: formato de email válido (sin exists para prevenir enumeración OWASP).
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
        ];
    }

    /**
     * Mensajes de error personalizados traducibles.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => __('messages.validation_email_required'),
            'email.email' => __('messages.validation_email_email'),
        ];
    }
}
