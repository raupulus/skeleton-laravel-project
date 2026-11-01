<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * FormRequest para la creación de tokens de API personales.
 * Solo requiere un nombre descriptivo para identificar el token.
 */
class TokenCreateRequest extends FormRequest
{
    /**
     * Solo los usuarios autenticados pueden crear tokens (verificado por middleware).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación: el nombre del token es obligatorio y tiene longitud máxima.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
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
            'name.required' => __('messages.validation_token_name_required'),
            'name.max' => __('messages.validation_token_name_max'),
        ];
    }
}
