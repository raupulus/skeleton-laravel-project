<?php
namespace App\Filament\Admin\Resources;
use App\Models\Category;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-tag';
    protected static string|\UnitEnum|null $navigationGroup = 'Contenido';
    protected static ?string $modelLabel = 'Categoría';
    protected static ?string $pluralModelLabel = 'Categorías';
    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Tabs::make('Traducciones')->tabs([
                Tab::make('Español')->schema([Forms\Components\TextInput::make('name.es')->label('Nombre (ES)')->required(),Forms\Components\Textarea::make('description.es')->label('Descripción (ES)')]),
                Tab::make('English')->schema([Forms\Components\TextInput::make('name.en')->label('Name (EN)'),Forms\Components\Textarea::make('description.en')->label('Description (EN)')]),
            ])->columnSpanFull(),
            Forms\Components\TextInput::make('slug')->unique(ignoreRecord: true),
            Forms\Components\FileUpload::make('image')->image()->maxSize(2048)->directory('categories'),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\TextInput::make('order')->numeric()->default(0),
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([Tables\Columns\TextColumn::make('slug')->sortable(),Tables\Columns\TextColumn::make('name')->searchable(),Tables\Columns\IconColumn::make('is_active')->boolean(),Tables\Columns\TextColumn::make('order')->sortable()])->actions([\Filament\Actions\EditAction::make()]);
    }
    public static function getPages(): array
    {
        return ['index'=>CategoryResource\Pages\ListCategories::route('/'),'create'=>CategoryResource\Pages\CreateCategory::route('/create'),'edit'=>CategoryResource\Pages\EditCategory::route('/{record}/edit')];
    }
}
