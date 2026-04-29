<?php
namespace App\Filament\Admin\Resources;
use App\Enums\ContentStatus;
use App\Models\Post;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';
    protected static string|\UnitEnum|null $navigationGroup = 'Contenido';
    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Tabs::make('Traducciones')->tabs([
                Tab::make('Español')->schema([
                    Forms\Components\TextInput::make('title.es')->label('Título (ES)')->required(),
                    Forms\Components\RichEditor::make('content.es')->label('Contenido (ES)'),
                    Forms\Components\Textarea::make('excerpt.es')->label('Extracto (ES)'),
                    Forms\Components\TextInput::make('seo_title.es'),Forms\Components\Textarea::make('seo_description.es'),Forms\Components\TextInput::make('seo_keywords.es'),
                ]),
                Tab::make('English')->schema([
                    Forms\Components\TextInput::make('title.en')->label('Title (EN)'),
                    Forms\Components\RichEditor::make('content.en'),Forms\Components\Textarea::make('excerpt.en'),
                    Forms\Components\TextInput::make('seo_title.en'),Forms\Components\Textarea::make('seo_description.en'),Forms\Components\TextInput::make('seo_keywords.en'),
                ]),
            ])->columnSpanFull(),
            Forms\Components\TextInput::make('slug')->unique(ignoreRecord: true),
            Forms\Components\FileUpload::make('image')->image()->maxSize(2048)->directory('posts'),
            Forms\Components\Select::make('status')->options(collect(ContentStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()]))->default('draft'),
            Forms\Components\Toggle::make('featured'),Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\Select::make('categories')
                ->relationship(
                    name: 'categories',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn ($query) => $query->reorder()
                )
                ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('name', app()->getLocale()))
                ->multiple()
                ->preload(),
            Forms\Components\DateTimePicker::make('published_at'),
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
        ])->actions([\Filament\Actions\EditAction::make()]);
    }
    public static function getPages(): array
    {
        return [
            'index' => PostResource\Pages\ListPosts::route('/'),
            'create' => PostResource\Pages\CreatePost::route('/create'),
            'edit' => PostResource\Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
