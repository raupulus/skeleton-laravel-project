<?php

namespace App\Filament\Admin\Resources;

use App\Enums\ContentStatus;
use App\Filament\Components\ImageCropField;
use App\Models\Category;
use App\Models\Page;
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
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

/**
 * Recurso Filament para gestionar las páginas de contenido en el panel admin.
 */
class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'slug';

    /**
     * Atributos para la búsqueda global de Filament.
     *
     * @return array<string>
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['slug', 'title'];
    }

    /**
     * Devuelve el label del modelo traducido.
     */
    public static function getModelLabel(): string
    {
        return __('filament.page');
    }

    /**
     * Devuelve el label plural del modelo traducido.
     */
    public static function getPluralModelLabel(): string
    {
        return __('filament.pages');
    }

    /**
     * Devuelve el grupo de navegación traducido.
     */
    public static function getNavigationGroup(): ?string
    {
        return __('filament.nav_content');
    }

    /**
     * Permite acceder y restaurar registros con borrado lógico.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    /**
     * Define el formulario del recurso Página.
     */
    public static function form(Schema $form): Schema
    {
        return $form->schema([
            // 1. Imagen con cropper 16:9 — primer campo, ancho completo
            ImageCropField::make16x9('image', 'pages'),

            // 2. Traducciones con labels correctos (incluidos SEO)
            Tabs::make(__('filament.translations'))->tabs([
                Tab::make(__('filament.tab_spanish'))->schema([
                    Forms\Components\TextInput::make('title.es')->label(__('filament.title').' (ES)')->required()->maxLength(255),
                    Forms\Components\RichEditor::make('content.es')->label(__('filament.content').' (ES)'),
                    Forms\Components\Textarea::make('excerpt.es')->label(__('filament.excerpt').' (ES)')->maxLength(1000),
                    Forms\Components\TextInput::make('seo_title.es')->label(__('filament.seo_title').' (ES)')->maxLength(160),
                    Forms\Components\Textarea::make('seo_description.es')->label(__('filament.seo_description').' (ES)')->maxLength(320),
                    Forms\Components\TextInput::make('seo_keywords.es')->label(__('filament.seo_keywords').' (ES)')->maxLength(255),
                ]),
                Tab::make(__('filament.tab_english'))->schema([
                    Forms\Components\TextInput::make('title.en')->label(__('filament.title').' (EN)')->maxLength(255),
                    Forms\Components\RichEditor::make('content.en')->label(__('filament.content').' (EN)'),
                    Forms\Components\Textarea::make('excerpt.en')->label(__('filament.excerpt').' (EN)')->maxLength(1000),
                    Forms\Components\TextInput::make('seo_title.en')->label(__('filament.seo_title').' (EN)')->maxLength(160),
                    Forms\Components\Textarea::make('seo_description.en')->label(__('filament.seo_description').' (EN)')->maxLength(320),
                    Forms\Components\TextInput::make('seo_keywords.en')->label(__('filament.seo_keywords').' (EN)')->maxLength(255),
                ]),
            ])->columnSpanFull(),

            // 3. Slug debajo del título, ancho completo
            Forms\Components\TextInput::make('slug')
                ->label(__('filament.slug'))
                ->maxLength(255)
                ->unique(ignoreRecord: true, modifyRuleUsing: fn (Unique $rule) => $rule->whereNull('deleted_at'))
                ->columnSpanFull(),

            // 4. Status y Categories al mismo nivel (50%-50%)
            Forms\Components\Select::make('status')
                ->label(__('filament.status'))
                ->options(ContentStatus::class)
                ->required()
                ->default(ContentStatus::Draft->value),
            Forms\Components\Select::make('categories')
                ->label(__('filament.categories'))
                ->relationship(
                    name: 'categories',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn ($query) => $query->reorder()
                )
                ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('name', app()->getLocale()))
                ->multiple()
                ->preload()
                ->createOptionForm([
                    Tabs::make(__('filament.translations'))->tabs([
                        Tab::make(__('filament.tab_spanish'))->schema([
                            Forms\Components\TextInput::make('name.es')
                                ->label(__('filament.name').' (ES)')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Textarea::make('description.es')
                                ->label(__('filament.description').' (ES)')
                                ->maxLength(1000),
                        ]),
                        Tab::make(__('filament.tab_english'))->schema([
                            Forms\Components\TextInput::make('name.en')
                                ->label(__('filament.name').' (EN)')
                                ->maxLength(255),
                            Forms\Components\Textarea::make('description.en')
                                ->label(__('filament.description').' (EN)')
                                ->maxLength(1000),
                        ]),
                    ])->columnSpanFull(),
                    Forms\Components\TextInput::make('slug')
                        ->label(__('filament.slug'))
                        ->maxLength(255)
                        ->unique('categories', 'slug', modifyRuleUsing: fn (Unique $rule) => $rule->whereNull('deleted_at')),
                    Forms\Components\Toggle::make('is_active')
                        ->label(__('filament.is_active'))
                        ->default(true),
                ])
                ->createOptionUsing(function (array $data): int {
                    $category = Category::create([
                        'name' => array_filter([
                            'es' => $data['name']['es'] ?? null,
                            'en' => $data['name']['en'] ?? null,
                        ]),
                        'description' => array_filter([
                            'es' => $data['description']['es'] ?? null,
                            'en' => $data['description']['en'] ?? null,
                        ]),
                        'slug' => $data['slug'] ?? Str::slug(
                            $data['name']['es'] ?? $data['name']['en'] ?? ''
                        ),
                        'is_active' => $data['is_active'] ?? true,
                    ]);

                    return $category->id;
                }),

            // 5. is_active y featured debajo de status/categories (al mismo nivel, 50%-50%)
            Forms\Components\Toggle::make('is_active')
                ->label(__('filament.is_active'))
                ->default(true),
            Forms\Components\Toggle::make('featured')
                ->label(__('filament.featured')),

            // 6. Fecha de publicación
            Forms\Components\DateTimePicker::make('published_at')
                ->label(__('filament.published_at')),
        ]);
    }

    /**
     * Define la tabla del recurso Página.
     */
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('slug')
                ->label(__('filament.slug'))
                ->searchable()
                ->sortable()
                ->limit(35)
                ->toggleable(),
            Tables\Columns\TextColumn::make('title')
                ->label(__('filament.title'))
                ->searchable()
                ->limit(45),
            Tables\Columns\TextColumn::make('status')
                ->label(__('filament.status'))
                ->badge(),
            Tables\Columns\IconColumn::make('featured')
                ->label(__('filament.featured'))
                ->boolean()
                ->toggleable(),
            Tables\Columns\TextColumn::make('published_at')
                ->label(__('filament.published_at'))
                ->dateTime('d/m/Y')
                ->sortable()
                ->toggleable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')
                ->label(__('filament.status'))
                ->options(ContentStatus::class),
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
     * Define las páginas del recurso Página.
     *
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => PageResource\Pages\ListPages::route('/'),
            'create' => PageResource\Pages\CreatePage::route('/create'),
            'edit' => PageResource\Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
