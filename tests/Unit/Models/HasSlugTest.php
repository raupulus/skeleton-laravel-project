<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests para verificar el comportamiento del trait HasSlug
 * en diferentes escenarios (slugs vacíos, duplicados, modelos con name vs title).
 */
class HasSlugTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que un post genera slug automáticamente desde el título.
     */
    public function test_post_generates_slug_from_title(): void
    {
        $post = Post::factory()->create([
            'title' => ['es' => 'Mi primer post', 'en' => 'My first post'],
            'slug' => null,
        ]);

        $this->assertNotEmpty($post->slug);
        $this->assertStringContainsString('mi-primer-post', $post->slug);
    }

    /**
     * Verifica que dos posts con el mismo título generan slugs diferentes.
     */
    public function test_duplicate_titles_generate_unique_slugs(): void
    {
        $post1 = Post::factory()->create([
            'title' => ['es' => 'Duplicado', 'en' => 'Duplicate'],
            'slug' => null,
        ]);
        $post2 = Post::factory()->create([
            'title' => ['es' => 'Duplicado', 'en' => 'Duplicate'],
            'slug' => null,
        ]);

        $this->assertNotEquals($post1->slug, $post2->slug);
    }

    /**
     * Verifica que un modelo con título vacío genera un slug aleatorio (no vacío).
     */
    public function test_empty_title_generates_random_slug(): void
    {
        $post = Post::factory()->create([
            'title' => ['es' => '', 'en' => ''],
            'slug' => null,
        ]);

        $this->assertNotEmpty($post->slug);
        $this->assertGreaterThanOrEqual(8, strlen($post->slug));
    }

    /**
     * Verifica que Category genera slug desde 'name' (no 'title').
     */
    public function test_category_generates_slug_from_name(): void
    {
        $category = Category::create([
            'name' => ['es' => 'Tecnología', 'en' => 'Technology'],
            'is_active' => true,
        ]);

        $this->assertNotEmpty($category->slug);
        $this->assertStringContainsString('tecnologia', $category->slug);
    }

    /**
     * Verifica que un slug proporcionado manualmente no se sobreescribe.
     */
    public function test_manual_slug_is_preserved(): void
    {
        $post = Post::factory()->create([
            'title' => ['es' => 'Título cualquiera', 'en' => 'Any title'],
            'slug' => 'mi-slug-manual',
        ]);

        $this->assertEquals('mi-slug-manual', $post->slug);
    }
}
