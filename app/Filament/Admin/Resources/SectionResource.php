<?php
namespace App\Filament\Admin\Resources;
use App\Filament\Components\ImageCropField;
use App\Models\Section;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * Recurso Filament para gestionar las secciones dinámicas del frontend.
 */
class SectionResource extends Resource
{
    protected static ?string $model = Section::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?int $navigationSort = 6;

    /**
     * Devuelve el label del modelo traducido.
     *
     * @return string
     */
    public static function getModelLabel(): string
    {
        return __('filament.section');
    }

    /**
     * Devuelve el label plural del modelo traducido.
     *
     * @return string
     */
    public static function getPluralModelLabel(): string
    {
        return __('filament.sections');
    }

    /**
     * Devuelve el grupo de navegación traducido.
     *
     * @return string|null
     */
    public static function getNavigationGroup(): ?string
    {
        return __('filament.nav_frontend');
    }

    /**
     * @param  Schema  $form
     * @return Schema
     */
    public static function form(Schema $form): Schema
    {
        return $form->schema([
            // Imagen con cropper 16:9 — primer campo, ancho completo
            ImageCropField::make16x9('image', 'sections'),

            // Traducciones con labels correctos
            Tabs::make(__('filament.translations'))->tabs([
                Tab::make(__('filament.tab_spanish'))->schema([
                    Forms\Components\TextInput::make('title.es')->label(__('filament.title') . ' (ES)')->required(),
                    Forms\Components\Textarea::make('description.es')->label(__('filament.description') . ' (ES)'),
                    Forms\Components\RichEditor::make('content.es')->label(__('filament.content') . ' (ES)'),
                ]),
                Tab::make(__('filament.tab_english'))->schema([
                    Forms\Components\TextInput::make('title.en')->label(__('filament.title') . ' (EN)'),
                    Forms\Components\Textarea::make('description.en')->label(__('filament.description') . ' (EN)'),
                    Forms\Components\RichEditor::make('content.en')->label(__('filament.content') . ' (EN)'),
                ]),
            ])->columnSpanFull(),

            // Slug debajo del título, ancho completo
            Forms\Components\TextInput::make('slug')
                ->label(__('filament.slug'))
                ->unique(ignoreRecord: true)
                ->columnSpanFull(),

            // Zone y Order con labels traducidos
            Forms\Components\TextInput::make('zone')
                ->label(__('filament.zone'))
                ->required()
                ->datalist(fn () => Section::query()
                    ->select('zone')
                    ->distinct()
                    ->whereNotNull('zone')
                    ->pluck('zone')
                    ->toArray()
                ),
            Forms\Components\TextInput::make('order')
                ->label(__('filament.order'))
                ->numeric()
                ->default(0),
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
            Tables\Columns\TextColumn::make('zone')->label(__('filament.zone'))->sortable(),
            Tables\Columns\TextColumn::make('title')->label(__('filament.title')),
            Tables\Columns\TextColumn::make('order')->label(__('filament.order'))->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('zone')
                ->label(__('filament.zone'))
                ->options(fn () => Section::query()->select('zone')->distinct()->pluck('zone', 'zone')->toArray()),
            Tables\Filters\TrashedFilter::make(),
        ])
        ->actions([
            \Filament\Actions\EditAction::make(),
            \Filament\Actions\DeleteAction::make(),
            \Filament\Actions\RestoreAction::make(),
            \Filament\Actions\ForceDeleteAction::make(),
        ])
        ->defaultSort('zone');
    }

    /** @return array<string, \Filament\Resources\Pages\PageRegistration> */
    public static function getPages(): array
    {
        return [
            'index'  => SectionResource\Pages\ListSections::route('/'),
            'create' => SectionResource\Pages\CreateSection::route('/create'),
            'edit'   => SectionResource\Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
