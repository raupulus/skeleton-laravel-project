<?php

namespace Database\Factories;

use App\Enums\EmailStatus;
use App\Models\SentEmail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para el modelo SentEmail.
 * Genera registros de emails enviados para pruebas.
 *
 * @extends Factory<SentEmail>
 */
class SentEmailFactory extends Factory
{
    protected $model = SentEmail::class;

    /**
     * Definición del estado por defecto de la factory.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'to'             => fake()->safeEmail(),
            'from'           => config('mail.from.address', 'noreply@example.com'),
            'subject'        => fake()->sentence(),
            'body'           => fake()->paragraphs(3, true),
            'mailable_class' => 'App\\Mail\\GenericMail',
            'status'         => fake()->randomElement(EmailStatus::cases()),
            'error_message'  => null,
            'metadata'       => null,
        ];
    }
}
