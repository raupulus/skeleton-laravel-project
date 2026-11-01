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
}
