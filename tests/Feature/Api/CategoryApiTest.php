<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests para los endpoints de la API de categorías.
 */
class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que el listado de categorías devuelve solo las activas.
     */
    public function test_index_returns_active_categories(): void
    {
        Category::create(['name' => ['es' => 'Activa'], 'slug' => 'activa', 'is_active' => true]);
        Category::create(['name' => ['es' => 'Inactiva'], 'slug' => 'inactiva', 'is_active' => false]);

        $response = $this->getJson('/api/v1/categories');

        $response->assertOk();
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['slug' => 'activa']);
        $response->assertJsonMissing(['slug' => 'inactiva']);
    }

    /**
     * Verifica que se puede obtener una categoría por slug.
     */
    public function test_show_returns_category_by_slug(): void
    {
        Category::create(['name' => ['es' => 'Tech', 'en' => 'Tech'], 'slug' => 'tech', 'is_active' => true]);

        $response = $this->getJson('/api/v1/categories/tech');

        $response->assertOk();
        $response->assertJsonFragment(['slug' => 'tech']);
    }

    /**
     * Verifica que un slug inexistente devuelve 404.
     */
    public function test_show_returns_404_for_nonexistent_slug(): void
    {
        $response = $this->getJson('/api/v1/categories/no-existe');

        $response->assertNotFound();
    }

    /**
     * Verifica que una categoría inactiva no es accesible por slug.
     */
    public function test_show_returns_404_for_inactive_category(): void
    {
        Category::create(['name' => ['es' => 'Oculta'], 'slug' => 'oculta', 'is_active' => false]);

        $response = $this->getJson('/api/v1/categories/oculta');

        $response->assertNotFound();
    }
}
