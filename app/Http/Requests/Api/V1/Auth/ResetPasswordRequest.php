<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * FormRequest para restablecer la contraseña del usuario.
 * Requiere el token de restablecimiento, el email, la nueva contraseña y su confirmación.
 */
class ResetPasswordRequest extends FormRequest
{
    /**
     * Cualquier usuario puede completar el restablecimiento de contraseña con token válido.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para el restablecimiento de contraseña.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'token'    => ['required', 'string'],
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
            'token.required'     => 'El token de restablecimiento es obligatorio.',
            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.email'        => 'El correo electrónico no es válido.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ];
    }
}
