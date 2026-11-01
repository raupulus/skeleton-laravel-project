<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * FormRequest para el inicio de sesión de usuarios a través de la API.
 * Valida las credenciales de acceso: email y contraseña.
 */
class LoginRequest extends FormRequest
{
    /**
     * El login está disponible para cualquier persona no autenticada.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para el inicio de sesión.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'string'],
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
            'password.required' => __('messages.validation_password_required'),
        ];
    }
}
