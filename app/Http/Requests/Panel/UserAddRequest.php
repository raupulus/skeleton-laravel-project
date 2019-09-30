<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserAddRequest
 *
 * Valida las peticiones de request al agregar usuarios antes de procesarlas.
 *
 * @package App\Http\Requests
 */
class UserAddRequest extends FormRequest
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
            'name' => 'min:4|max:220',
            'nick' => 'required|unique:users,nick|min:4|max:220',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'nullable|min:6',
        ];
    }

    /**
     * Mensajes utilizados para las respuestas de validación.
     *
     * @return array
     */
    /*
    public function messages()
    {
        return [
            'email' => 'Se requiere un formato de email válido',
            'required' => 'El campo :attribute es obligatorio',
            'accepted' => 'El campo :attribute debe ser aceptado',
            'numeric' => 'El campo :attribute tiene que ser numérico',
            'min' => 'El campo :attribute no cumple con la longitud mínima',
            'max' => 'El campo :attribute supera la longitud máxima',
            'unique' => 'Ya existe el :attribute registrado',
        ];
    }
    */
}
