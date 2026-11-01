<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para perfiles de redes sociales (almacenados en el modelo Setting con group='social').
 *
 * @extends Factory<Setting>
 */
class SocialMediaFactory extends Factory
{
    /**
     * El modelo asociado a la factory.
     *
     * @var class-string<Setting>
     */
    protected $model = Setting::class;

    /**
     * Redes sociales disponibles.
     *
     * @var array<string, string>
     */
    protected array $platforms = [
        'facebook_url' => 'Facebook',
        'twitter_url' => 'Twitter/X',
        'instagram_url' => 'Instagram',
        'linkedin_url' => 'LinkedIn',
        'youtube_url' => 'YouTube',
        'github_url' => 'GitHub',
        'tiktok_url' => 'TikTok',
    ];

    /**
     * Definición del estado por defecto de la factory.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $platformKey = fake()->unique()->randomElement(array_keys($this->platforms));
        $platformName = $this->platforms[$platformKey];

        return [
            'key' => $platformKey,
            'display_name' => $platformName,
            'value' => 'https://'.strtolower($platformName).'.com/'.fake()->userName(),
            'details' => 'Enlace al perfil corporativo de '.$platformName,
            'type' => 'text',
            'order' => fake()->numberBetween(1, 10),
            'group' => 'social',
        ];
    }

    /**
     * Estado activo (con URL válida asignada).
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'value' => $attributes['value'] ?? 'https://linkedin.com/company/'.fake()->slug(),
        ]);
    }

    /**
     * Estado inactivo (con valor nulo o vacío).
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'value' => null,
        ]);
    }
}
