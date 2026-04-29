<?php
namespace App\Filament\Admin\Resources;
use App\Enums\ContentStatus;
use App\Models\Page;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected static string|\UnitEnum|null $navigationGroup = 'Contenido';
    protected static ?string $modelLabel = 'Página';
    protected static ?string $pluralModelLabel = 'Páginas';

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Tabs::make('Traducciones')->tabs([
                Tab::make('Español')->schema([
                    Forms\Components\TextInput::make('title.es')->label('Título (ES)')->required(),
                    Forms\Components\RichEditor::make('content.es')->label('Contenido (ES)'),
                    Forms\Components\Textarea::make('excerpt.es')->label('Extracto (ES)'),
                    Forms\Components\TextInput::make('seo_title.es')->label('SEO Título (ES)'),
                    Forms\Components\Textarea::make('seo_description.es')->label('SEO Descripción (ES)'),
                    Forms\Components\TextInput::make('seo_keywords.es')->label('SEO Keywords (ES)'),
                ]),
                Tab::make('English')->schema([
                    Forms\Components\TextInput::make('title.en')->label('Title (EN)'),
                    Forms\Components\RichEditor::make('content.en')->label('Content (EN)'),
                    Forms\Components\Textarea::make('excerpt.en')->label('Excerpt (EN)'),
                    Forms\Components\TextInput::make('seo_title.en')->label('SEO Title (EN)'),
                    Forms\Components\Textarea::make('seo_description.en')->label('SEO Description (EN)'),
                    Forms\Components\TextInput::make('seo_keywords.en')->label('SEO Keywords (EN)'),
                ]),
            ])->columnSpanFull(),
            Forms\Components\TextInput::make('slug')->unique(ignoreRecord: true),
            Forms\Components\FileUpload::make('image')->image()->maxSize(2048)->directory('pages'),
            Forms\Components\Select::make('status')->options(collect(ContentStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()]))->default('draft'),
            Forms\Components\Toggle::make('featured'),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\Select::make('categories')
                ->relationship(
                    name: 'categories',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn ($query) => $query->reorder()
                )
                ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('name', app()->getLocale()))
                ->multiple()
                ->preload(),
            Forms\Components\DateTimePicker::make('published_at')->label('Fecha de publicación'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('slug')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('title')->searchable(),
            Tables\Columns\TextColumn::make('status')->badge()->color(fn ($state) => $state->color()),
            Tables\Columns\IconColumn::make('featured')->boolean(),
            Tables\Columns\TextColumn::make('published_at')->dateTime('d/m/Y')->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')->options(collect(ContentStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])),
        ])->actions([\Filament\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => PageResource\Pages\ListPages::route('/'),
            'create' => PageResource\Pages\CreatePage::route('/create'),
            'edit' => PageResource\Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
