<?php

namespace Database\Factories;

use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Factory para el modelo Section.
 * Genera secciones dinámicas de prueba con traducciones es/en.
 *
 * @extends Factory<Section>
 */
class SectionFactory extends Factory
{
    protected $model = Section::class;

    /**
     * Definición del estado por defecto de la factory.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titleEs = fake()->unique()->words(3, true);

        return [
            'slug' => Str::slug($titleEs),
            'zone' => fake()->randomElement(['home', 'about', 'contact']),
            'title' => ['es' => $titleEs, 'en' => fake()->unique()->words(3, true)],
            'description' => ['es' => fake()->sentence(), 'en' => fake()->sentence()],
            'content' => ['es' => fake()->paragraphs(2, true), 'en' => fake()->paragraphs(2, true)],
            'image' => null,
            'order' => fake()->numberBetween(0, 10),
        ];
    }
}
