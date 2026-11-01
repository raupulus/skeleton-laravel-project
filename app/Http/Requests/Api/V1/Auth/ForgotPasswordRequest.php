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
     * Reglas de validación: el email debe existir en la tabla users.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'exists:users,email'],
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
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.exists' => 'No existe ninguna cuenta con ese correo electrónico.',
        ];
    }
}
