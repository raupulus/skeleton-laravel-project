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
        Schema::create('users', function (Blueprint $table) {
            $table->comment('Tabla de usuarios registrados en la plataforma');
            $table->id()->comment('Identificador único del usuario');
            $table->string('name', 255)->comment('Nombre completo del usuario');
            $table->string('email', 255)->unique()->comment('Correo electrónico único del usuario');
            $table->timestamp('email_verified_at')->nullable()->comment('Fecha y hora de verificación del email');
            $table->string('password')->comment('Contraseña del usuario (hash bcrypt)');
            $table->string('role', 20)->default('user')->comment('Rol del usuario: superadmin, admin, user');
            $table->string('avatar', 512)->nullable()->comment('Ruta de la imagen de avatar del usuario');
            $table->boolean('is_active')->default(true)->comment('Indica si el usuario está activo en la plataforma');
            $table->rememberToken()->comment('Token para recordar la sesión del usuario');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha de eliminación lógica del usuario');

            $table->index('role', 'idx_users_role');
            $table->index('is_active', 'idx_users_is_active');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->comment('Tokens para el restablecimiento de contraseñas de usuarios');
            $table->string('email')->primary()->comment('Correo electrónico del usuario solicitante');
            $table->string('token')->comment('Token hash único de restablecimiento');
            $table->timestamp('created_at')->nullable()->comment('Fecha y hora de creación del token');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->comment('Sesiones activas de usuarios en la plataforma');
            $table->string('id')->primary()->comment('Identificador único de la sesión');
            $table->foreignId('user_id')->nullable()->index()->comment('ID del usuario autenticado (si aplica)');
            $table->string('ip_address', 45)->nullable()->comment('Dirección IP de origen del usuario');
            $table->text('user_agent')->nullable()->comment('Agente de usuario / navegador');
            $table->longText('payload')->comment('Datos serializados de la sesión');
            $table->integer('last_activity')->index()->comment('Marca de tiempo de la última actividad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
