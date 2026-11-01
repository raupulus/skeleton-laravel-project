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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->comment('Tokens de acceso personal para autenticación en la API REST (Sanctum)');
            $table->id()->comment('Identificador único del token');
            $table->morphs('tokenable');
            $table->text('name')->comment('Nombre descriptivo asignado al token');
            $table->string('token', 64)->unique()->comment('Hash criptográfico único del Bearer token');
            $table->text('abilities')->nullable()->comment('Habilidades y permisos del token en formato JSON');
            $table->timestamp('last_used_at')->nullable()->comment('Última fecha y hora en que se utilizó el token');
            $table->timestamp('expires_at')->nullable()->index()->comment('Fecha y hora de caducidad del token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
