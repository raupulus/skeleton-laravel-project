<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->comment('Categorías compartidas entre páginas y posts');
            $table->id()->comment('Identificador único de la categoría');
            $table->string('slug', 255)->comment('Slug URL único de la categoría');
            $table->jsonb('name')->comment('Nombre de la categoría (traducible: es, en)');
            $table->jsonb('description')->nullable()->comment('Descripción de la categoría (traducible: es, en)');
            $table->string('image', 512)->nullable()->comment('Ruta de la imagen de la categoría');
            $table->boolean('is_active')->default(true)->comment('Indica si la categoría está activa');
            $table->integer('order')->default(0)->comment('Orden de visualización de la categoría');
            $table->timestamp('created_at')->nullable()->comment('Fecha y hora de creación de la categoría');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última actualización de la categoría');
            $table->softDeletes()->comment('Fecha de eliminación lógica');
            $table->index('is_active', 'idx_categories_is_active');
            $table->index('order', 'idx_categories_order');
        });

        DB::statement('CREATE UNIQUE INDEX categories_slug_unique ON categories (slug) WHERE deleted_at IS NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
