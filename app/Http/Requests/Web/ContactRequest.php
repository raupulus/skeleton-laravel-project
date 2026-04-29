<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

/**
 * FormRequest para el formulario de contacto del sitio web.
 * Valida todos los campos del formulario incluyendo la aceptación de privacidad.
 */
class ContactRequest extends FormRequest
{
    /**
     * Cualquier visitante puede enviar el formulario de contacto.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para el formulario de contacto.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'string', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'privacy' => ['required', 'accepted'],
        ];
    }

    /**
     * Mensajes de error personalizados en español para el formulario de contacto.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'    => 'El nombre es obligatorio.',
            'name.max'         => 'El nombre no puede superar 255 caracteres.',
            'email.required'   => 'El correo electrónico es obligatorio.',
            'email.email'      => 'El correo electrónico no es válido.',
            'subject.required' => 'El asunto es obligatorio.',
            'message.required' => 'El mensaje es obligatorio.',
            'message.max'      => 'El mensaje no puede superar 5.000 caracteres.',
            'privacy.required' => 'Debes aceptar la política de privacidad.',
            'privacy.accepted' => 'Debes aceptar la política de privacidad.',
        ];
    }
}
