<?php
namespace App\Filament\Admin\Resources;
use App\Models\Setting;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
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
     *
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('filament.setting');
    }
    /**
     * Devuelve el label plural del modelo traducido.
     *
     * @return string
     */
    public static function getPluralModelLabel(): string
    {
        return __('filament.settings');
    }
    /**
     * Devuelve el grupo de navegación traducido.
     *
     * @return string|null
     */
    public static function getNavigationGroup(): ?string
    {
        return __('filament.nav_system');
    }
    /**
     * Define el formulario del recurso Configuración.
     *
     * @param  Schema  $form
     * @return Schema
     */
    public static function form(Schema $form): Schema
    {
        return $form->schema([
            // 1. Display name — primer campo, ancho completo
            Forms\Components\TextInput::make('display_name')
                ->label(__('filament.display_name'))
                ->required()
                ->columnSpanFull(),
            // 2. Value — segundo campo, ancho completo
            Forms\Components\Textarea::make('value')
                ->label(__('filament.value'))
                ->columnSpanFull(),
            // 3. Key y Type juntos (50%-50%)
            Forms\Components\TextInput::make('key')
                ->label(__('filament.key'))
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\Select::make('type')
                ->label(__('filament.type'))
                ->options([
                    'text'     => __('filament.type_text'),
                    'textarea' => __('filament.type_textarea'),
                    'image'    => __('filament.type_image'),
                    'number'   => __('filament.type_number'),
                ])
                ->default('text'),
            // 4. Group y Order juntos (50%-50%)
            Forms\Components\TextInput::make('group')
                ->label(__('filament.group'))
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
                ->default(0),

            // 5. Details
            Forms\Components\Textarea::make('details')
                ->label(__('filament.details'))
                ->columnSpanFull(),
        ]);
    }
    /**
     * Define la tabla del recurso Configuración.
     *
     * @param  Table  $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('key')
                ->label(__('filament.key'))
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('display_name')
                ->label(__('filament.display_name')),
            Tables\Columns\TextColumn::make('value')
                ->label(__('filament.value'))
                ->limit(50),
            Tables\Columns\TextColumn::make('group')
                ->label(__('filament.group'))
                ->sortable(),
        ])
        ->actions([\Filament\Actions\EditAction::make()])
        ->defaultSort('group');
    }
    /**
     * @return array<string, \Filament\Resources\Pages\PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index'  => SettingResource\Pages\ListSettings::route('/'),
            'create' => SettingResource\Pages\CreateSetting::route('/create'),
            'edit'   => SettingResource\Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
