<?php
namespace App\Filament\Admin\Resources;
use App\Models\Section;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
class SectionResource extends Resource
{
    protected static ?string $model = Section::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';
    protected static string|\UnitEnum|null $navigationGroup = 'Frontend';
    protected static ?string $modelLabel = 'Sección';
    protected static ?string $pluralModelLabel = 'Secciones';
    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Tabs::make('Traducciones')->tabs([
                Tab::make('Español')->schema([Forms\Components\TextInput::make('title.es'),Forms\Components\Textarea::make('description.es'),Forms\Components\RichEditor::make('content.es')]),
                Tab::make('English')->schema([Forms\Components\TextInput::make('title.en'),Forms\Components\Textarea::make('description.en'),Forms\Components\RichEditor::make('content.en')]),
            ])->columnSpanFull(),
            Forms\Components\TextInput::make('slug')->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('zone')->required(),
            Forms\Components\FileUpload::make('image')->image()->maxSize(2048)->directory('sections'),
            Forms\Components\TextInput::make('order')->numeric()->default(0),
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([Tables\Columns\TextColumn::make('slug')->sortable(),Tables\Columns\TextColumn::make('zone')->sortable(),Tables\Columns\TextColumn::make('title'),Tables\Columns\TextColumn::make('order')->sortable()])->actions([\Filament\Actions\EditAction::make()])->defaultSort('zone');
    }
    public static function getPages(): array
    {
        return ['index'=>SectionResource\Pages\ListSections::route('/'),'create'=>SectionResource\Pages\CreateSection::route('/create'),'edit'=>SectionResource\Pages\EditSection::route('/{record}/edit')];
    }
}
