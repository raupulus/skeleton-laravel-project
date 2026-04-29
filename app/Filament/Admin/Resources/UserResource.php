<?php

namespace App\Filament\Admin\Resources;

use App\Enums\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';
    protected static string|\UnitEnum|null $navigationGroup = 'Sistema';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('password')->password()->required(fn ($record) => !$record)->minLength(8)->dehydrated(fn ($state) => filled($state)),
            Forms\Components\Select::make('role')->options(collect(Role::cases())->mapWithKeys(fn ($r) => [$r->value => $r->label()]))->required(),
            Forms\Components\FileUpload::make('avatar')->image()->maxSize(2048)->directory('avatars'),
            Forms\Components\Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('role')->badge()->formatStateUsing(fn ($state) => $state->label())->color(fn ($state) => $state->isAdmin() ? 'primary' : 'gray'),
            Tables\Columns\IconColumn::make('is_active')->boolean(),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y')->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('role')->options(collect(Role::cases())->mapWithKeys(fn ($r) => [$r->value => $r->label()])),
            Tables\Filters\TernaryFilter::make('is_active'),
        ])->actions([\Filament\Actions\EditAction::make()])->bulkActions([\Filament\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => UserResource\Pages\ListUsers::route('/'),
            'create' => UserResource\Pages\CreateUser::route('/create'),
            'edit' => UserResource\Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
