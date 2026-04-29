<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

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
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Mensajes de error personalizados en español para cada regla de validación.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'      => 'El nombre es obligatorio.',
            'name.max'           => 'El nombre no puede superar 255 caracteres.',
            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.email'        => 'El correo electrónico no es válido.',
            'email.unique'       => 'Este correo electrónico ya está registrado.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ];
    }
}
