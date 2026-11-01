<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

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
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
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
            'token.required' => __('messages.validation_token_required'),
            'email.required' => __('messages.validation_email_required'),
            'email.email' => __('messages.validation_email_email'),
            'password.required' => __('messages.validation_password_required'),
            'password.min' => __('messages.validation_password_min'),
            'password.confirmed' => __('messages.validation_password_confirmed'),
        ];
    }
}
