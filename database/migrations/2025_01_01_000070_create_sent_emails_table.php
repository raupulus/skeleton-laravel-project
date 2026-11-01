<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sent_emails', function (Blueprint $table) {
            $table->comment('Registro de todos los emails enviados por la plataforma');
            $table->id()->comment('Identificador único del registro de email');
            $table->string('to', 512)->comment('Dirección de email del destinatario');
            $table->string('from', 512)->comment('Dirección de email del remitente');
            $table->string('subject', 512)->comment('Asunto del email');
            $table->text('body')->comment('Cuerpo/contenido del email en HTML');
            $table->string('mailable_class', 255)->comment('Nombre completo de la clase Mailable utilizada');
            $table->string('status', 20)->default('sent')->comment('Estado del envío: sent, failed');
            $table->text('error_message')->nullable()->comment('Mensaje de error si el envío falló');
            $table->jsonb('metadata')->nullable()->comment('Datos adicionales en JSON');
            $table->timestamp('created_at')->nullable()->comment('Fecha y hora de creación del registro de email');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última actualización del registro de email');
            $table->index('status', 'idx_sent_emails_status');
            $table->index('created_at', 'idx_sent_emails_created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sent_emails');
    }
};
