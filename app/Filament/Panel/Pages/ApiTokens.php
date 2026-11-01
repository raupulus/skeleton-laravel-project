<?php

namespace App\Filament\Panel\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;

/**
 * Página de gestión de tokens API del usuario autenticado en el panel de usuario.
 */
class ApiTokens extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-key';

    protected string $view = 'filament.panel.pages.api-tokens';

    public string $tokenName = '';

    public ?string $plainTextToken = null;

    /**
     * Devuelve el label de navegación traducido.
     */
    public static function getNavigationLabel(): string
    {
        return __('filament.api_tokens_nav');
    }

    /**
     * Devuelve el título de la página traducido.
     */
    public function getTitle(): string
    {
        return __('filament.api_tokens');
    }

    /**
     * Crea un nuevo token de API para el usuario autenticado.
     */
    public function createToken(): void
    {
        $this->validate([
            'tokenName' => 'required|string|max:255',
        ], [
            'tokenName.required' => __('messages.validation_token_name_required'),
            'tokenName.max' => __('messages.validation_token_name_max'),
        ]);

        $token = auth()->user()->createToken($this->tokenName);
        $this->plainTextToken = $token->plainTextToken;
        $this->tokenName = '';

        Notification::make()->title(__('messages.api_tokens_created_notify'))->success()->send();
    }

    /**
     * Elimina un token de API por su ID.
     */
    public function deleteToken(int $tokenId): void
    {
        auth()->user()->tokens()->where('id', $tokenId)->delete();
        $this->plainTextToken = null;

        Notification::make()->title(__('messages.api_tokens_deleted_notify'))->success()->send();
    }

    /**
     * Devuelve todos los tokens del usuario autenticado ordenados por fecha de creación.
     */
    #[Computed]
    public function tokens(): Collection
    {
        return auth()->user()->tokens()->orderByDesc('created_at')->get();
    }
}
