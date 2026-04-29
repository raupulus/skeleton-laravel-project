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
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Mensajes de error personalizados en español.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'El correo electrónico no es válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ];
    }
}
