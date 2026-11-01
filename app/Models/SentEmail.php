<?php

namespace App\Models;

use App\Enums\EmailStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de registro de emails enviados por la plataforma.
 * Cada email enviado a través del EmailService se registra automáticamente
 * en esta tabla para auditoría y consulta desde el backend.
 *
 * @property int $id
 * @property string $to Dirección email del destinatario
 * @property string|null $from Dirección email del remitente
 * @property string $subject Asunto del email
 * @property string $body Cuerpo del email (HTML)
 * @property string $mailable_class Clase PHP del Mailable utilizado
 * @property EmailStatus $status Estado: sent o failed
 * @property string|null $error_message Mensaje de error si el envío falló
 * @property array|null $metadata Datos adicionales en formato JSON
 */
class SentEmail extends Model
{
    use HasFactory;

    /** @var array<string> Campos asignables en masa */
    protected $fillable = [
        'to', 'from', 'subject', 'body', 'mailable_class',
        'status', 'error_message', 'metadata',
    ];

    /**
     * Definición de casts de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => EmailStatus::class,
            'metadata' => 'array',
        ];
    }

    // =========================================================
    // SCOPES
    // =========================================================

    /**
     * Scope para filtrar solo los emails enviados exitosamente.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeSent($query)
    {
        return $query->where('status', EmailStatus::Sent);
    }

    /**
     * Scope para filtrar solo los emails que fallaron al enviarse.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeFailed($query)
    {
        return $query->where('status', EmailStatus::Failed);
    }
}
