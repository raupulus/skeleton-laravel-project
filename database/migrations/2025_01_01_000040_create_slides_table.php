<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->comment('Slides multimedia agrupados por zona para carruseles y galerías');
            $table->id()->comment('Identificador único del slide');
            $table->jsonb('title')->nullable()->comment('Título del slide (traducible: es, en)');
            $table->jsonb('content')->nullable()->comment('Texto descriptivo del slide (traducible: es, en)');
            $table->string('image', 512)->comment('Ruta de la imagen principal del slide (formato 16:9, obligatorio)');
            $table->string('image_vertical', 512)->nullable()->comment('Ruta de la imagen vertical del slide (formato 8:12, opcional)');
            $table->string('url', 512)->nullable()->comment('URL de destino al hacer clic en el slide');
            $table->string('zone', 100)->comment('Zona/grupo al que pertenece el slide');
            $table->integer('order')->default(0)->comment('Orden de visualización dentro de la zona');
            $table->boolean('is_active')->default(true)->comment('Indica si el slide está activo');
            $table->timestamp('created_at')->nullable()->comment('Fecha y hora de creación del slide');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última actualización del slide');
            $table->softDeletes()->comment('Fecha de eliminación lógica');
            $table->index('zone', 'idx_slides_zone');
            $table->index('is_active', 'idx_slides_is_active');
            $table->index(['zone', 'is_active', 'order'], 'idx_slides_zone_active_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
