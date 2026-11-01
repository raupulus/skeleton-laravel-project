<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->comment('Trabajos en cola pendientes de procesamiento');
            $table->id()->comment('Identificador único del trabajo');
            $table->string('queue')->index()->comment('Nombre de la cola asignada');
            $table->longText('payload')->comment('Datos y comando serializado del trabajo');
            $table->unsignedTinyInteger('attempts')->comment('Número de intentos de ejecución');
            $table->unsignedInteger('reserved_at')->nullable()->comment('Marca de tiempo de reserva por un worker');
            $table->unsignedInteger('available_at')->comment('Marca de tiempo a partir de la cual está disponible');
            $table->unsignedInteger('created_at')->comment('Marca de tiempo de creación del trabajo');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->comment('Lotes de trabajos ejecutados de forma coordinada');
            $table->string('id')->primary()->comment('Identificador único UUID del lote');
            $table->string('name')->comment('Nombre descriptivo del lote');
            $table->integer('total_jobs')->comment('Número total de trabajos en el lote');
            $table->integer('pending_jobs')->comment('Número de trabajos pendientes');
            $table->integer('failed_jobs')->comment('Número de trabajos fallidos');
            $table->longText('failed_job_ids')->comment('Lista de IDs de trabajos que fallaron');
            $table->mediumText('options')->nullable()->comment('Opciones y callbacks serializados del lote');
            $table->integer('cancelled_at')->nullable()->comment('Marca de tiempo si el lote fue cancelado');
            $table->integer('created_at')->comment('Marca de tiempo de creación del lote');
            $table->integer('finished_at')->nullable()->comment('Marca de tiempo de finalización del lote');
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->comment('Registro histórico de trabajos que fallaron definitivamente');
            $table->id()->comment('Identificador único del registro');
            $table->string('uuid')->unique()->comment('UUID del trabajo fallido');
            $table->text('connection')->comment('Nombre de la conexión de cola utilizada');
            $table->text('queue')->comment('Nombre de la cola en la que se encontraba');
            $table->longText('payload')->comment('Carga de datos serializada del trabajo');
            $table->longText('exception')->comment('Traza completa de la excepción o error');
            $table->timestamp('failed_at')->useCurrent()->comment('Fecha y hora del fallo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
