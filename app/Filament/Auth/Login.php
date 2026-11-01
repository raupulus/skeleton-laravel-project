<?php

namespace App\Filament\Auth;

use App\Rules\Recaptcha;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Página de inicio de sesión personalizada para los paneles Filament (/admin y /panel).
 * Integra Google reCAPTCHA v3 de forma opcional cuando RECAPTCHA_SITE_KEY y RECAPTCHA_SECRET_KEY
 * están configurados en el entorno (.env), omitiéndolo silenciosamente si están vacíos o null.
 */
class Login extends BaseLogin
{
    /**
     * Define los componentes del formulario de login incluyendo reCAPTCHA v3 opcional.
     */
    public function form(Schema $schema): Schema
    {
        $components = [
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getRememberFormComponent(),
        ];

        if ($this->isRecaptchaEnabled()) {
            $components[] = Hidden::make('g-recaptcha-response')
                ->default('');
            $components[] = View::make('filament.auth.recaptcha');
        }

        return $schema->components($components);
    }

    /**
     * Valida reCAPTCHA v3 (si está activo) antes de delegar en la autenticación de Filament.
     */
    public function authenticate(): ?LoginResponse
    {
        if ($this->isRecaptchaEnabled()) {
            $token = $this->data['g-recaptcha-response'] ?? '';

            $validator = Validator::make(
                ['g-recaptcha-response' => $token],
                ['g-recaptcha-response' => [new Recaptcha('login')]]
            );

            if ($validator->fails()) {
                throw ValidationException::withMessages([
                    'data.email' => $validator->errors()->first('g-recaptcha-response'),
                ]);
            }
        }

        return parent::authenticate();
    }

    /**
     * Normaliza el email antes de verificar credenciales.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => mb_strtolower(trim((string) ($data['email'] ?? ''))),
            'password' => $data['password'] ?? '',
        ];
    }

    /**
     * Determina si Google reCAPTCHA v3 está configurado en el entorno.
     */
    protected function isRecaptchaEnabled(): bool
    {
        return filled(config('services.recaptcha.site_key'))
            && filled(config('services.recaptcha.secret_key'));
    }
}
