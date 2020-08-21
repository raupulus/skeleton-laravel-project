<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->slug),
        ]);
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
            'title' => 'required|min:10|max:500',
            'slug' => [
                'required',
                'min:5',
                'max:511',
                Rule::unique('contents', 'slug')->ignore($this->id)
            ],
            'excerpt' => 'nullable|min:10|max:250',
            'image' => 'nullable',
            'body' => 'nullable',
            'og_title' => 'nullable|max:55',
            'description' => 'nullable|max:155',
            'keywords' => 'nullable|max:500',
            'robots' => 'nullable|max:50',
            'og_description' => 'nullable|max:155',
            'og_image' => 'nullable',
            'og_image_alt' => 'nullable|max:200',
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
