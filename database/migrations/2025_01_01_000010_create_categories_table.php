<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->comment('Categorías compartidas entre páginas y posts');
            $table->id()->comment('Identificador único de la categoría');
            $table->string('slug', 255)->unique()->comment('Slug URL único de la categoría');
            $table->jsonb('name')->comment('Nombre de la categoría (traducible: es, en)');
            $table->jsonb('description')->nullable()->comment('Descripción de la categoría (traducible: es, en)');
            $table->string('image', 512)->nullable()->comment('Ruta de la imagen de la categoría');
            $table->boolean('is_active')->default(true)->comment('Indica si la categoría está activa');
            $table->integer('order')->default(0)->comment('Orden de visualización de la categoría');
            $table->timestamps();
            $table->softDeletes()->comment('Fecha de eliminación lógica');
            $table->index('is_active', 'idx_categories_is_active');
            $table->index('order', 'idx_categories_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
