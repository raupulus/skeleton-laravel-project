<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UserAddRequest
 *
 * Valida las peticiones de request al agregar usuarios antes de procesarlas.
 *
 * @package App\Http\Requests
 */
class ContentAddRequest extends FormRequest
{
    /**
     * Permisos para el usuario enviar request.
     *
     * @return bool
     */
    public function authorize()
    {
        ## TODO → Admin siempre, también propietario y colaboradores
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
            'content_id' => 'nullable|numeric',
            'type_id' => 'nullable|numeric',
            'status_id' => 'nullable|numeric',
            'title' => 'required|min:10|max:511',
            'slug' => [
                'required',
                Rule::unique('contents', 'slug')->ignore($this->id)
            ],
            'excerpt' => 'nullable',
            'image' => 'nullable',
            'body' => 'nullable',
            'og_title' => 'nullable',
            'description' => 'nullable',
            'keywords' => 'nullable',
            'robots' => 'nullable',
            'og_description' => 'nullable',
            'og_image_alt' => 'nullable',
            'og_image_id' => 'nullable',
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
