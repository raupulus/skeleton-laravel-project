<?php

namespace App\Filament\Panel\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Attributes\Computed;

class ApiTokens extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-key';
    protected static ?string $title = 'Tokens de API';
    protected static ?string $navigationLabel = 'Tokens API';
    protected string $view = 'filament.panel.pages.api-tokens';

    public string $tokenName = '';
    public ?string $plainTextToken = null;

    /**
     * Crea un nuevo token de API para el usuario autenticado.
     */
    public function createToken(): void
    {
        $this->validate([
            'tokenName' => 'required|string|max:255',
        ], [
            'tokenName.required' => 'El nombre del token es obligatorio.',
            'tokenName.max'      => 'El nombre no puede superar los 255 caracteres.',
        ]);

        $token = auth()->user()->createToken($this->tokenName);
        $this->plainTextToken = $token->plainTextToken;
        $this->tokenName = '';

        Notification::make()->title('Token creado correctamente.')->success()->send();
    }

    /**
     * Elimina un token de API por su ID.
     */
    public function deleteToken(int $tokenId): void
    {
        auth()->user()->tokens()->where('id', $tokenId)->delete();
        $this->plainTextToken = null;

        Notification::make()->title('Token eliminado correctamente.')->success()->send();
    }

    /**
     * Devuelve todos los tokens del usuario autenticado ordenados por fecha de creación.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    #[Computed]
    public function tokens(): \Illuminate\Database\Eloquent\Collection
    {
        return auth()->user()->tokens()->orderByDesc('created_at')->get();
    }
}
