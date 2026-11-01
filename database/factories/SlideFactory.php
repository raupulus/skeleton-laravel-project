<?php

namespace Database\Factories;

use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para el modelo Slide.
 * Genera slides de prueba con traducciones es/en.
 *
 * @extends Factory<Slide>
 */
class SlideFactory extends Factory
{
    protected $model = Slide::class;

    /**
     * Definición del estado por defecto de la factory.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ['es' => fake()->sentence(3), 'en' => fake()->sentence(3)],
            'content' => ['es' => fake()->paragraph(), 'en' => fake()->paragraph()],
            'image' => 'images/default/default_800x600.png',
            'image_vertical' => null,
            'url' => fake()->optional()->url(),
            'zone' => fake()->randomElement(['home', 'about', 'services']),
            'order' => fake()->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}
