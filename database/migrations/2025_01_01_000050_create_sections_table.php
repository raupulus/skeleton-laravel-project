<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->comment('Secciones dinámicas para rellenar zonas del frontend desde el backend');
            $table->id()->comment('Identificador único de la sección');
            $table->string('slug', 255)->comment('Slug URL único de la sección');
            $table->string('zone', 100)->comment('Zona/página a la que pertenece (home, about, contact...)');
            $table->jsonb('title')->nullable()->comment('Título de la sección (traducible: es, en)');
            $table->jsonb('description')->nullable()->comment('Descripción breve de la sección (traducible: es, en)');
            $table->jsonb('content')->nullable()->comment('Contenido completo de la sección (traducible: es, en)');
            $table->string('image', 512)->nullable()->comment('Ruta de la imagen de la sección');
            $table->integer('order')->default(0)->comment('Orden de visualización dentro de la zona');
            $table->timestamp('created_at')->nullable()->comment('Fecha y hora de creación de la sección');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última actualización de la sección');
            $table->softDeletes()->comment('Fecha de eliminación lógica');
            $table->index('zone', 'idx_sections_zone');
            $table->index(['zone', 'order'], 'idx_sections_zone_order');
        });

        DB::statement('CREATE UNIQUE INDEX sections_slug_unique ON sections (slug) WHERE deleted_at IS NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
