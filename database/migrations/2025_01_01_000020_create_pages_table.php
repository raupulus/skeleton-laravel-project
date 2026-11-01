<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->comment('Páginas estáticas editables desde el backend');
            $table->id()->comment('Identificador único de la página');
            $table->string('slug', 255)->comment('Slug URL único de la página');
            $table->jsonb('title')->comment('Título de la página (traducible: es, en)');
            $table->jsonb('content')->nullable()->comment('Contenido completo de la página (traducible: es, en)');
            $table->jsonb('excerpt')->nullable()->comment('Extracto o resumen de la página (traducible: es, en)');
            $table->string('image', 512)->nullable()->comment('Ruta de la imagen principal de la página');
            $table->string('status', 20)->default('draft')->comment('Estado de la página: draft, published');
            $table->boolean('is_active')->default(true)->comment('Indica si la página está activa');
            $table->boolean('featured')->default(false)->comment('Indica si la página está destacada');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate()->comment('Usuario que creó la página');
            $table->jsonb('seo_title')->nullable()->comment('Título SEO de la página (traducible: es, en)');
            $table->jsonb('seo_description')->nullable()->comment('Descripción SEO de la página (traducible: es, en)');
            $table->jsonb('seo_keywords')->nullable()->comment('Palabras clave SEO de la página (traducible: es, en)');
            $table->timestamp('published_at')->nullable()->comment('Fecha y hora de publicación');
            $table->timestamp('created_at')->nullable()->comment('Fecha y hora de creación de la página');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última actualización de la página');
            $table->softDeletes()->comment('Fecha de eliminación lógica');
            $table->index('status', 'idx_pages_status');
            $table->index('is_active', 'idx_pages_is_active');
            $table->index('featured', 'idx_pages_featured');
            $table->index('user_id', 'idx_pages_user_id');
            $table->index('published_at', 'idx_pages_published_at');
            $table->index(['status', 'is_active'], 'idx_pages_status_active');
        });

        DB::statement('CREATE UNIQUE INDEX pages_slug_unique ON pages (slug) WHERE deleted_at IS NULL');

        Schema::create('category_page', function (Blueprint $table) {
            $table->comment('Tabla pivot que relaciona categorías con páginas');
            $table->id()->comment('Identificador único de la relación categoría-página');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade')->comment('ID de la categoría');
            $table->foreignId('page_id')->constrained('pages')->onDelete('cascade')->onUpdate('cascade')->comment('ID de la página');
            $table->unique(['category_id', 'page_id'], 'uq_category_page');
            $table->index('page_id', 'idx_category_page_page_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_page');
        Schema::dropIfExists('pages');
    }
};
