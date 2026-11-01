<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Factory para categorías de posts (modelo Category).
 * Genera categorías con nombres traducibles (es/en) y generación automática de slug.
 *
 * @extends Factory<Category>
 */
class PostCategoryFactory extends Factory
{
    /**
     * El modelo asociado a la factory.
     *
     * @var class-string<Category>
     */
    protected $model = Category::class;

    /**
     * Definición del estado por defecto.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nameEs = fake()->unique()->words(2, true);
        $nameEn = fake()->unique()->words(2, true);

        return [
            'slug' => Str::slug($nameEs),
            'name' => [
                'es' => ucfirst($nameEs),
                'en' => ucfirst($nameEn),
            ],
            'description' => [
                'es' => fake()->sentence(),
                'en' => fake()->sentence(),
            ],
            'image' => null,
            'is_active' => true,
            'order' => fake()->numberBetween(0, 20),
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
