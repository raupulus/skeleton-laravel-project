<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para el modelo Setting.
 * Genera configuraciones de prueba.
 *
 * @extends Factory<Setting>
 */
class SettingFactory extends Factory
{
    protected $model = Setting::class;

    /**
     * Definición del estado por defecto de la factory.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key'          => fake()->unique()->slug(2),
            'display_name' => fake()->words(3, true),
            'value'        => fake()->sentence(),
            'details'      => null,
            'type'         => 'text',
            'order'        => fake()->numberBetween(0, 10),
            'group'        => fake()->randomElement(['general', 'seo', 'social', 'contact']),
        ];
    }
}
