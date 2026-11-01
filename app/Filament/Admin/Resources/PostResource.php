<?php

namespace App\Filament\Admin\Resources;

use App\Enums\ContentStatus;
use App\Filament\Components\ImageCropField;
use App\Models\Category;
use App\Models\Post;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Forms;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

/**
 * Recurso Filament para gestionar los posts (artículos) en el panel admin.
 */
class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';

    protected static ?int $navigationSort = 2;

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
        return __('filament.post');
    }

    /**
     * Devuelve el label plural del modelo traducido.
     */
    public static function getPluralModelLabel(): string
    {
        return __('filament.posts');
    }

    /**
     * Devuelve el grupo de navegación traducido.
     */
    public static function getNavigationGroup(): ?string
    {
        return __('filament.nav_content');
    }

    /**
     * Define el formulario del recurso Post.
     */
    public static function form(Schema $form): Schema
    {
        return $form->schema([
            // 1. Imagen con cropper 16:9 — primer campo, ancho completo
            ImageCropField::make16x9('image', 'posts'),

            // 2. Traducciones con labels correctos (incluidos SEO)
            Tabs::make(__('filament.translations'))->tabs([
                Tab::make(__('filament.tab_spanish'))->schema([
                    Forms\Components\TextInput::make('title.es')->label(__('filament.title').' (ES)')->required(),
                    Forms\Components\RichEditor::make('content.es')->label(__('filament.content').' (ES)'),
                    Forms\Components\Textarea::make('excerpt.es')->label(__('filament.excerpt').' (ES)'),
                    Forms\Components\TextInput::make('seo_title.es')->label(__('filament.seo_title').' (ES)'),
                    Forms\Components\Textarea::make('seo_description.es')->label(__('filament.seo_description').' (ES)'),
                    Forms\Components\TextInput::make('seo_keywords.es')->label(__('filament.seo_keywords').' (ES)'),
                ]),
                Tab::make(__('filament.tab_english'))->schema([
                    Forms\Components\TextInput::make('title.en')->label(__('filament.title').' (EN)'),
                    Forms\Components\RichEditor::make('content.en')->label(__('filament.content').' (EN)'),
                    Forms\Components\Textarea::make('excerpt.en')->label(__('filament.excerpt').' (EN)'),
                    Forms\Components\TextInput::make('seo_title.en')->label(__('filament.seo_title').' (EN)'),
                    Forms\Components\Textarea::make('seo_description.en')->label(__('filament.seo_description').' (EN)'),
                    Forms\Components\TextInput::make('seo_keywords.en')->label(__('filament.seo_keywords').' (EN)'),
                ]),
            ])->columnSpanFull(),

            // 3. Slug debajo del título, ancho completo
            Forms\Components\TextInput::make('slug')
                ->label(__('filament.slug'))
                ->unique(ignoreRecord: true)
                ->columnSpanFull(),

            // 4. Status y Categories al mismo nivel (50%-50%)
            Forms\Components\Select::make('status')
                ->label(__('filament.status'))
                ->options(collect(ContentStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()]))
                ->default('draft'),
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
                                ->required(),
                            Forms\Components\Textarea::make('description.es')
                                ->label(__('filament.description').' (ES)'),
                        ]),
                        Tab::make(__('filament.tab_english'))->schema([
                            Forms\Components\TextInput::make('name.en')
                                ->label(__('filament.name').' (EN)'),
                            Forms\Components\Textarea::make('description.en')
                                ->label(__('filament.description').' (EN)'),
                        ]),
                    ])->columnSpanFull(),
                    Forms\Components\TextInput::make('slug')
                        ->label(__('filament.slug'))
                        ->unique('categories', 'slug'),
                    Forms\Components\Toggle::make('is_active')
                        ->label(__('filament.is_active'))
                        ->default(true),
                ])
                ->createOptionUsing(function (array $data): int {
                    // Construir los campos traducibles como arrays para spatie/translatable
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
     * Define la tabla del recurso Post.
     */
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('slug')->label(__('filament.slug'))->searchable()->sortable(),
            Tables\Columns\TextColumn::make('title')->label(__('filament.title'))->searchable(),
            Tables\Columns\TextColumn::make('status')->label(__('filament.status'))->badge()->color(fn ($state) => $state->color()),
            Tables\Columns\IconColumn::make('featured')->label(__('filament.featured'))->boolean(),
            Tables\Columns\TextColumn::make('published_at')->label(__('filament.published_at'))->dateTime('d/m/Y')->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')
                ->label(__('filament.status'))
                ->options(collect(ContentStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])),
            Tables\Filters\TrashedFilter::make(),
        ])->actions([
            EditAction::make(),
            DeleteAction::make(),
            RestoreAction::make(),
            ForceDeleteAction::make(),
        ]);
    }

    /**
     * Define las páginas del recurso Post.
     *
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => PostResource\Pages\ListPosts::route('/'),
            'create' => PostResource\Pages\CreatePost::route('/create'),
            'edit' => PostResource\Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
