<?php

namespace App\Filament\Panel\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditProfile extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user';
    protected static ?string $title = 'Mi Perfil';
    protected static ?string $navigationLabel = 'Mi Perfil';
    protected string $view = 'filament.panel.pages.edit-profile';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(auth()->user()->toArray());
    }

    public function form(Schema $form): Schema
    {
        return $form->schema([
            TextInput::make('name')->label('Nombre')->required(),
            TextInput::make('email')->label('Email')->email()->disabled(),
            FileUpload::make('avatar')->label('Avatar')->image()->directory('avatars'),
            TextInput::make('password')->label('Nueva contraseña')->password()->minLength(8)->dehydrated(fn ($state) => filled($state)),
        ])->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $user = auth()->user();
        $user->name = $data['name'];
        if (!empty($data['avatar'])) { $user->avatar = $data['avatar']; }
        if (!empty($data['password'])) { $user->password = bcrypt($data['password']); }
        $user->save();
        Notification::make()->title('Perfil actualizado correctamente.')->success()->send();
    }
}
