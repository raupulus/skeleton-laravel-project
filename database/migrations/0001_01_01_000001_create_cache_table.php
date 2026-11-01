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
        Schema::create('cache', function (Blueprint $table) {
            $table->comment('Almacén de elementos en caché de la aplicación');
            $table->string('key')->primary()->comment('Clave identificadora única del elemento en caché');
            $table->mediumText('value')->comment('Valor serializado almacenado');
            $table->bigInteger('expiration')->index()->comment('Marca de tiempo Unix de expiración');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->comment('Cerrojos atómicos para control de concurrencia en caché');
            $table->string('key')->primary()->comment('Clave del cerrojo');
            $table->string('owner')->comment('Identificador del proceso propietario del cerrojo');
            $table->bigInteger('expiration')->index()->comment('Marca de tiempo Unix de expiración del cerrojo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
