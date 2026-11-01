<?php

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(),
            'title' => ['es' => fake()->sentence(), 'en' => fake()->sentence()],
            'content' => ['es' => '<p>'.fake()->paragraphs(3, true).'</p>', 'en' => '<p>'.fake()->paragraphs(3, true).'</p>'],
            'excerpt' => ['es' => fake()->sentence(), 'en' => fake()->sentence()],
            'status' => ContentStatus::Published,
            'is_active' => true,
            'featured' => false,
            'user_id' => User::factory(),
            'published_at' => now(),
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

    /**
     * Estado publicado.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ContentStatus::Published,
            'is_active' => true,
            'published_at' => now(),
        ]);
    }

    /**
     * Estado borrador.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ContentStatus::Draft,
            'published_at' => null,
        ]);
    }

    /**
     * Genera contenido con bloques modulares del Page Builder.
     */
    public function withModularBlocks(): static
    {
        return $this->state(fn (array $attributes) => [
            'content' => [
                'es' => [
                    [
                        'type' => 'text',
                        'data' => ['content' => '<p>'.fake()->paragraph().'</p>'],
                    ],
                    [
                        'type' => 'cta',
                        'data' => [
                            'title' => 'Soluciones a Medida',
                            'description' => 'Contáctanos para más información.',
                            'button_text' => 'Contactar',
                            'button_url' => '/contact',
                        ],
                    ],
                ],
                'en' => [
                    [
                        'type' => 'text',
                        'data' => ['content' => '<p>'.fake()->paragraph().'</p>'],
                    ],
                    [
                        'type' => 'cta',
                        'data' => [
                            'title' => 'Custom Solutions',
                            'description' => 'Contact us for further details.',
                            'button_text' => 'Contact Us',
                            'button_url' => '/contact',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
