<?php

namespace App\Services;

use App\Enums\EmailStatus;
use App\Models\SentEmail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Servicio centralizado para el envío de emails de la plataforma.
 * Todos los emails enviados a través de este servicio se registran automáticamente
 * en la tabla sent_emails para auditoría y consulta desde el backend.
 * Si el envío falla, se registra el error pero no se lanza la excepción.
 */
class EmailService
{
    /**
     * Envía un email y lo registra en la tabla sent_emails.
     * Si el envío falla, registra el error con status=failed en lugar de lanzar una excepción.
     *
     * @param  Mailable  $mailable  El objeto Mailable con el contenido del email
     * @param  string    $to        La dirección email del destinatario
     * @param  string    $subject   El asunto del email (para el registro)
     * @return SentEmail            El registro creado en sent_emails
     */
    public function send(Mailable $mailable, string $to, string $subject): SentEmail
    {
        $fromAddress = config('mail.from.address', 'noreply@example.com');

        // Intentar renderizar el email; si falla, registrar como fallido
        try {
            $body = $mailable->render();
        } catch (Throwable $e) {
            return SentEmail::create([
                'to'             => $to,
                'from'           => $fromAddress,
                'subject'        => $subject,
                'body'           => '',
                'mailable_class' => get_class($mailable),
                'status'         => EmailStatus::Failed,
                'error_message'  => $e->getMessage(),
            ]);
        }

        // Crear el registro del email con estado inicial 'sent'
        $sentEmail = SentEmail::create([
            'to'             => $to,
            'from'           => $fromAddress,
            'subject'        => $subject,
            'body'           => $body,
            'mailable_class' => get_class($mailable),
            'status'         => EmailStatus::Sent,
        ]);

        try {
            // Intentar enviar el email real
            Mail::to($to)->send($mailable);
        } catch (Throwable $e) {
            // Si falla el envío, actualizar el registro con el error
            $sentEmail->update([
                'status'        => EmailStatus::Failed,
                'error_message' => $e->getMessage(),
            ]);
        }

        return $sentEmail;
    }
}
