<?php
namespace App\Filament\Admin\Resources;
use App\Models\Slide;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
class SlideResource extends Resource
{
    protected static ?string $model = Slide::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';
    protected static string|\UnitEnum|null $navigationGroup = 'Media';
    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Tabs::make('Traducciones')->tabs([
                Tab::make('Español')->schema([Forms\Components\TextInput::make('title.es'),Forms\Components\Textarea::make('content.es')]),
                Tab::make('English')->schema([Forms\Components\TextInput::make('title.en'),Forms\Components\Textarea::make('content.en')]),
            ])->columnSpanFull(),
            Forms\Components\FileUpload::make('image')->image()->required()->maxSize(2048)->imageEditor()->imageEditorAspectRatios(['16:9'])->directory('slides'),
            Forms\Components\FileUpload::make('image_vertical')->image()->maxSize(2048)->imageEditor()->imageEditorAspectRatios(['8:12'])->directory('slides'),
            Forms\Components\TextInput::make('url')->url(),Forms\Components\TextInput::make('zone')->required(),
            Forms\Components\TextInput::make('order')->numeric()->default(0),Forms\Components\Toggle::make('is_active')->default(true),
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([Tables\Columns\ImageColumn::make('image')->height(40),Tables\Columns\TextColumn::make('title'),Tables\Columns\TextColumn::make('zone')->sortable(),Tables\Columns\TextColumn::make('order')->sortable(),Tables\Columns\IconColumn::make('is_active')->boolean()])->actions([\Filament\Actions\EditAction::make()])->defaultSort('zone');
    }
    public static function getPages(): array
    {
        return ['index'=>SlideResource\Pages\ListSlides::route('/'),'create'=>SlideResource\Pages\CreateSlide::route('/create'),'edit'=>SlideResource\Pages\EditSlide::route('/{record}/edit')];
    }
}
