<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Factory para el modelo Category.
 * Genera categorías de prueba con traducciones es/en.
 *
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Definición del estado por defecto de la factory.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nameEs = fake()->unique()->words(2, true);

        return [
            'slug' => Str::slug($nameEs),
            'name' => ['es' => $nameEs, 'en' => fake()->unique()->words(2, true)],
            'description' => ['es' => fake()->sentence(), 'en' => fake()->sentence()],
            'image' => null,
            'is_active' => true,
            'order' => fake()->numberBetween(0, 10),
        ];
    }

    /**
     * Estado activo.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Estado inactivo.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
