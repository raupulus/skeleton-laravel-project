<?php

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

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
     * Estado publicado y activo.
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
     * Estado en borrador sin publicar.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ContentStatus::Draft,
            'published_at' => null,
        ]);
    }

    /**
     * Estado destacado.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'featured' => true,
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
