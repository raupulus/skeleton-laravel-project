<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->comment('Posts o artículos del blog de la plataforma');
            $table->id()->comment('Identificador único del post');
            $table->string('slug', 255)->comment('Slug URL único del post');
            $table->jsonb('title')->comment('Título del post (traducible: es, en)');
            $table->jsonb('content')->nullable()->comment('Contenido completo del post (traducible: es, en)');
            $table->jsonb('excerpt')->nullable()->comment('Extracto o resumen del post (traducible: es, en)');
            $table->string('image', 512)->nullable()->comment('Ruta de la imagen principal del post');
            $table->string('status', 20)->default('draft')->comment('Estado del post: draft, published');
            $table->boolean('is_active')->default(true)->comment('Indica si el post está activo');
            $table->boolean('featured')->default(false)->comment('Indica si el post está destacado');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate()->comment('Usuario que creó el post');
            $table->jsonb('seo_title')->nullable()->comment('Título SEO del post (traducible: es, en)');
            $table->jsonb('seo_description')->nullable()->comment('Descripción SEO del post (traducible: es, en)');
            $table->jsonb('seo_keywords')->nullable()->comment('Palabras clave SEO del post (traducible: es, en)');
            $table->timestamp('published_at')->nullable()->comment('Fecha y hora de publicación del post');
            $table->timestamp('created_at')->nullable()->comment('Fecha y hora de creación del post');
            $table->timestamp('updated_at')->nullable()->comment('Fecha y hora de última actualización del post');
            $table->softDeletes()->comment('Fecha de eliminación lógica');
            $table->index('status', 'idx_posts_status');
            $table->index('is_active', 'idx_posts_is_active');
            $table->index('featured', 'idx_posts_featured');
            $table->index('user_id', 'idx_posts_user_id');
            $table->index('published_at', 'idx_posts_published_at');
            $table->index('created_at', 'idx_posts_created_at');
            $table->index(['status', 'is_active', 'published_at'], 'idx_posts_status_active_published');
        });

        DB::statement('CREATE UNIQUE INDEX posts_slug_unique ON posts (slug) WHERE deleted_at IS NULL');

        Schema::create('category_post', function (Blueprint $table) {
            $table->comment('Tabla pivot que relaciona categorías con posts');
            $table->id()->comment('Identificador único de la relación categoría-post');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade')->comment('ID de la categoría');
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade')->onUpdate('cascade')->comment('ID del post');
            $table->unique(['category_id', 'post_id'], 'uq_category_post');
            $table->index('post_id', 'idx_category_post_post_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_post');
        Schema::dropIfExists('posts');
    }
};
