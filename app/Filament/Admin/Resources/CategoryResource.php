<?php
namespace App\Filament\Admin\Resources;
use App\Filament\Components\ImageCropField;
use App\Models\Category;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * Recurso Filament para gestionar las categorías en el panel admin.
 */
class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-tag';
    protected static ?int $navigationSort = 4;
    protected static ?string $recordTitleAttribute = 'slug';

    /**
     * Atributos para la búsqueda global de Filament.
     *
     * @return array<string>
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['slug', 'name'];
    }

    /**
     * Devuelve el label del modelo traducido.
     *
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('filament.category');
    }

    /**
     * Devuelve el label plural del modelo traducido.
     *
     * @return string
     */
    public static function getPluralModelLabel(): string
    {
        return __('filament.categories');
    }

    /**
     * Devuelve el grupo de navegación traducido.
     *
     * @return string|null
     */
    public static function getNavigationGroup(): ?string
    {
        return __('filament.nav_content');
    }

    /**
     * @param  Schema  $form
     * @return Schema
     */
    public static function form(Schema $form): Schema
    {
        return $form->schema([
            // 1. Imagen con cropper 16:9 — primer campo, ancho completo
            ImageCropField::make16x9('image', 'categories'),

            // 2. Traducciones
            Tabs::make(__('filament.translations'))->tabs([
                Tab::make(__('filament.tab_spanish'))->schema([
                    Forms\Components\TextInput::make('name.es')->label(__('filament.name') . ' (ES)')->required(),
                    Forms\Components\Textarea::make('description.es')->label(__('filament.description') . ' (ES)'),
                ]),
                Tab::make(__('filament.tab_english'))->schema([
                    Forms\Components\TextInput::make('name.en')->label(__('filament.name') . ' (EN)'),
                    Forms\Components\Textarea::make('description.en')->label(__('filament.description') . ' (EN)'),
                ]),
            ])->columnSpanFull(),

            // 3. Slug y Order al mismo nivel (50%-50%)
            Forms\Components\TextInput::make('slug')
                ->label(__('filament.slug'))
                ->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('order')
                ->label(__('filament.order'))
                ->numeric()
                ->default(0),

            // 4. Activo debajo
            Forms\Components\Toggle::make('is_active')
                ->label(__('filament.is_active'))
                ->default(true)
                ->columnSpanFull(),
        ]);
    }

    /**
     * @param  Table  $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('slug')->label(__('filament.slug'))->sortable(),
            Tables\Columns\TextColumn::make('name')->label(__('filament.name'))->searchable(),
            Tables\Columns\IconColumn::make('is_active')->label(__('filament.is_active'))->boolean(),
            Tables\Columns\TextColumn::make('order')->label(__('filament.order'))->sortable(),
        ])
        ->filters([
            Tables\Filters\TernaryFilter::make('is_active')
                ->label(__('filament.is_active')),
            Tables\Filters\TrashedFilter::make(),
        ])
        ->actions([
            \Filament\Actions\EditAction::make(),
            \Filament\Actions\DeleteAction::make(),
            \Filament\Actions\RestoreAction::make(),
            \Filament\Actions\ForceDeleteAction::make(),
        ]);
    }

    /** @return array<string, \Filament\Resources\Pages\PageRegistration> */
    public static function getPages(): array
    {
        return [
            'index'  => CategoryResource\Pages\ListCategories::route('/'),
            'create' => CategoryResource\Pages\CreateCategory::route('/create'),
            'edit'   => CategoryResource\Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
