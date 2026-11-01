<?php

namespace App\Filament\Panel\Pages;

use App\Filament\Components\ImageCropField;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * Página de edición de perfil del usuario autenticado en el panel de usuario.
 */
class EditProfile extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user';

    protected string $view = 'filament.panel.pages.edit-profile';

    public ?array $data = [];

    /**
     * Devuelve el label de navegación traducido.
     */
    public static function getNavigationLabel(): string
    {
        return __('filament.my_profile');
    }

    /**
     * Devuelve el título de la página traducido.
     */
    public function getTitle(): string
    {
        return __('filament.my_profile');
    }

    /**
     * Carga los datos del usuario autenticado al montar la página.
     */
    public function mount(): void
    {
        $this->form->fill(auth()->user()->toArray());
    }

    /**
     * Define el formulario del perfil de usuario.
     */
    public function form(Schema $form): Schema
    {
        return $form->schema([
            // 1. Avatar con cropper 4:3 — primer campo, ancho completo
            ImageCropField::make4x3('avatar', 'avatars'),

            // 2. Nombre
            TextInput::make('name')
                ->label(__('filament.name'))
                ->required()
                ->maxLength(255),

            // 3. Email (deshabilitado con nota)
            TextInput::make('email')
                ->label(__('filament.email'))
                ->email()
                ->disabled()
                ->helperText(__('messages.profile_email_helper')),

            // 4. Contraseña (con nota de "dejar en blanco")
            TextInput::make('password')
                ->label(__('filament.password'))
                ->password()
                ->revealable()
                ->rule(Password::defaults())
                ->confirmed()
                ->dehydrated(fn ($state) => filled($state))
                ->helperText(__('messages.profile_password_helper')),

            // 5. Confirmación de nueva contraseña
            TextInput::make('password_confirmation')
                ->label(__('messages.confirm_password'))
                ->password()
                ->revealable()
                ->dehydrated(false),
        ])->statePath('data');
    }

    /**
     * Guarda los cambios del perfil del usuario autenticado.
     */
    public function save(): void
    {
        $data = $this->form->getState();
        $user = auth()->user();
        $user->name = $data['name'];
        // Asignar el estado del avatar (incluyendo null si el usuario lo eliminó)
        $user->avatar = $data['avatar'] ?? null;
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();
        Notification::make()->title(__('messages.profile_updated'))->success()->send();
    }
}
