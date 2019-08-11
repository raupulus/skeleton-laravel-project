<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ContactRequest
 *
 * Valida las peticiones de request antes de procesarlas.
 *
 * @package App\Http\Requests
 */
class ContactRequest extends FormRequest
{
    /**
     * Permisos para el usuario enviar request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;  // Si a todos.
    }

    /**
     * Reglas de validación para la request.
     *
     * https://laravel.com/docs/5.8/validation#available-validation-rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:220',
            'email' => 'email',
            'phone' => 'numeric|nullable',
            'message' => 'required',
            'privacity' => 'accepted',
        ];
    }

    /**
     * Mensajes utilizados para las respuestas de validación.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email' => 'Se requiere un formato de email válido',
            'required' => 'El campo :attribute es obligatorio',
            'accepted' => 'El campo :attribute debe ser aceptado',
            'numeric' => 'El campo :attribute tiene que ser numérico'
        ];
    }
}
