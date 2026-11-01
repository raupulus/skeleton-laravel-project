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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
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
            'name.required' => __('messages.validation_name_required'),
            'name.max' => __('messages.validation_name_max'),
            'email.required' => __('messages.validation_email_required'),
            'email.email' => __('messages.validation_email_email'),
            'subject.required' => __('messages.validation_subject_required'),
            'message.required' => __('messages.validation_message_required'),
            'message.max' => __('messages.validation_message_max'),
            'privacy.required' => __('messages.validation_privacy_required'),
            'privacy.accepted' => __('messages.validation_privacy_accepted'),
        ];
    }
}
