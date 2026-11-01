<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * FormRequest para el registro de nuevos usuarios a través de la API.
 * Valida los datos requeridos: nombre, email único y contraseña con confirmación.
 */
class RegisterRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a hacer esta petición.
     * El registro está disponible para cualquier persona (no autenticada).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para el registro de usuario.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->whereNull('deleted_at')],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ];
    }

    /**
     * Mensajes de error personalizados traducibles para cada regla de validación.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('messages.validation_name_required'),
            'name.max' => __('messages.validation_name_max'),
            'email.required' => __('messages.validation_email_required'),
            'email.email' => __('messages.validation_email_email'),
            'email.unique' => __('messages.validation_email_unique'),
            'password.required' => __('messages.validation_password_required'),
            'password.min' => __('messages.validation_password_min'),
            'password.confirmed' => __('messages.validation_password_confirmed'),
        ];
    }
}
