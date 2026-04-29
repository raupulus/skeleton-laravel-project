<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->comment('Configuración general de la plataforma en formato clave-valor');
            $table->id()->comment('Identificador único del setting');
            $table->string('key', 255)->unique()->comment('Clave única del setting');
            $table->string('display_name', 255)->comment('Nombre legible del setting para mostrar en el panel');
            $table->text('value')->nullable()->comment('Valor del setting');
            $table->text('details')->nullable()->comment('Detalles o descripción adicional del setting');
            $table->string('type', 50)->default('text')->comment('Tipo de campo: text, textarea, image, select, checkbox, radio, number');
            $table->integer('order')->default(0)->comment('Orden de visualización');
            $table->string('group', 100)->default('general')->comment('Grupo al que pertenece: general, seo, social, contact');
            $table->timestamps();
            $table->index('group', 'idx_settings_group');
            $table->index('order', 'idx_settings_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
