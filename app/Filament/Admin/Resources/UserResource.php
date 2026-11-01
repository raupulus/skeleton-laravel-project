<?php

namespace App\Filament\Admin\Resources;

use App\Enums\Role;
use App\Filament\Components\ImageCropField;
use App\Models\User;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Unique;

/**
 * Recurso Filament para gestionar los usuarios en el panel admin.
 */
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * Atributos para la búsqueda global de Filament.
     *
     * @return array<string>
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getModelLabel(): string
    {
        return __('filament.user');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.users');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.nav_system');
    }

    /**
     * Permite filtrar y restaurar usuarios con borrado lógico ([BPANEL-04]).
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            // Avatar con cropper 4:3 — primer campo, ancho completo
            ImageCropField::make4x3('avatar', 'avatars'),
            Forms\Components\TextInput::make('name')
                ->label(__('filament.name'))
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->label(__('filament.email'))
                ->email()
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true, modifyRuleUsing: fn (Unique $rule) => $rule->whereNull('deleted_at')),
            Forms\Components\TextInput::make('password')
                ->label(__('filament.password'))
                ->password()
                ->revealable()
                ->required(fn ($record) => ! $record)
                ->rule(Password::defaults())
                ->dehydrated(fn ($state) => filled($state)),
            Forms\Components\Select::make('role')
                ->label(__('filament.role'))
                ->options(fn () => collect(Role::cases())
                    ->reject(fn (Role $r) => $r === Role::SuperAdmin && ! auth()->user()?->isSuperAdmin())
                    ->mapWithKeys(fn (Role $r) => [$r->value => $r->label()]))
                ->required(),
            Forms\Components\Toggle::make('is_active')
                ->label(__('filament.is_active'))
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')
                ->label(__('filament.name'))
                ->searchable()
                ->sortable()
                ->limit(35),
            Tables\Columns\TextColumn::make('email')
                ->label(__('filament.email'))
                ->searchable()
                ->sortable()
                ->limit(40)
                ->toggleable(),
            Tables\Columns\TextColumn::make('role')
                ->label(__('filament.role'))
                ->badge(),
            Tables\Columns\IconColumn::make('is_active')
                ->label(__('filament.is_active'))
                ->boolean(),
            Tables\Columns\TextColumn::make('created_at')
                ->label(__('filament.created_at'))
                ->dateTime('d/m/Y')
                ->sortable()
                ->toggleable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('role')
                ->label(__('filament.role'))
                ->options(Role::class),
            Tables\Filters\TernaryFilter::make('is_active')
                ->label(__('filament.is_active')),
            Tables\Filters\TrashedFilter::make(),
        ])->actions([
            ActionGroup::make([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ]),
        ])->bulkActions([
            DeleteBulkAction::make(),
            RestoreBulkAction::make(),
            ForceDeleteBulkAction::make(),
        ]);
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => UserResource\Pages\ListUsers::route('/'),
            'create' => UserResource\Pages\CreateUser::route('/create'),
            'edit' => UserResource\Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
