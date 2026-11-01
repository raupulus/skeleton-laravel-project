<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Components\ImageCropField;
use App\Models\Setting;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * Recurso Filament para gestionar las configuraciones del sistema.
 */
class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?int $navigationSort = 10;

    /**
     * Devuelve el label del modelo traducido.
     */
    public static function getModelLabel(): string
    {
        return __('filament.setting');
    }

    /**
     * Devuelve el label plural del modelo traducido.
     */
    public static function getPluralModelLabel(): string
    {
        return __('filament.settings');
    }

    /**
     * Devuelve el grupo de navegación traducido.
     */
    public static function getNavigationGroup(): ?string
    {
        return __('filament.nav_system');
    }

    /**
     * Define el formulario del recurso Configuración con campo de valor dinámico según type ([BPANEL-03]).
     */
    public static function form(Schema $form): Schema
    {
        return $form->schema([
            // 1. Display name — primer campo, ancho completo
            Forms\Components\TextInput::make('display_name')
                ->label(__('filament.display_name'))
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            // 2. Key y Type juntos (50%-50%)
            Forms\Components\TextInput::make('key')
                ->label(__('filament.key'))
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),
            Forms\Components\Select::make('type')
                ->label(__('filament.type'))
                ->options([
                    'text' => __('filament.type_text'),
                    'textarea' => __('filament.type_textarea'),
                    'image' => __('filament.type_image'),
                    'number' => __('filament.type_number'),
                ])
                ->required()
                ->default('text')
                ->live(),

            // 3. Value dinámico según el tipo seleccionado
            Forms\Components\TextInput::make('value')
                ->label(__('filament.value'))
                ->visible(fn (Get $get): bool => ($get('type') ?? 'text') === 'text')
                ->dehydrated(fn (Get $get): bool => ($get('type') ?? 'text') === 'text')
                ->columnSpanFull(),
            Forms\Components\Textarea::make('value')
                ->label(__('filament.value'))
                ->rows(4)
                ->visible(fn (Get $get): bool => $get('type') === 'textarea')
                ->dehydrated(fn (Get $get): bool => $get('type') === 'textarea')
                ->columnSpanFull(),
            Forms\Components\TextInput::make('value')
                ->label(__('filament.value'))
                ->numeric()
                ->visible(fn (Get $get): bool => $get('type') === 'number')
                ->dehydrated(fn (Get $get): bool => $get('type') === 'number')
                ->columnSpanFull(),
            ImageCropField::make16x9('value', 'settings', label: __('filament.value'))
                ->visible(fn (Get $get): bool => $get('type') === 'image')
                ->dehydrated(fn (Get $get): bool => $get('type') === 'image'),

            // 4. Group y Order juntos (50%-50%)
            Forms\Components\TextInput::make('group')
                ->label(__('filament.group'))
                ->required()
                ->maxLength(100)
                ->datalist(fn () => Setting::query()
                    ->select('group')
                    ->distinct()
                    ->whereNotNull('group')
                    ->pluck('group')
                    ->toArray()
                )
                ->default('general'),
            Forms\Components\TextInput::make('order')
                ->label(__('filament.order'))
                ->numeric()
                ->required()
                ->default(0),

            // 5. Details
            Forms\Components\Textarea::make('details')
                ->label(__('filament.details'))
                ->columnSpanFull(),
        ]);
    }

    /**
     * Define la tabla del recurso Configuración.
     */
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('key')
                ->label(__('filament.key'))
                ->searchable()
                ->sortable()
                ->limit(35),
            Tables\Columns\TextColumn::make('display_name')
                ->label(__('filament.display_name'))
                ->searchable()
                ->limit(40),
            Tables\Columns\TextColumn::make('value')
                ->label(__('filament.value'))
                ->limit(50)
                ->toggleable(),
            Tables\Columns\TextColumn::make('group')
                ->label(__('filament.group'))
                ->sortable()
                ->toggleable(),
        ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->defaultSort('group');
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => SettingResource\Pages\ListSettings::route('/'),
            'create' => SettingResource\Pages\CreateSetting::route('/create'),
            'edit' => SettingResource\Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
