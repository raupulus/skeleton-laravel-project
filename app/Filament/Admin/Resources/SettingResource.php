<?php
namespace App\Filament\Admin\Resources;
use App\Models\Setting;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string|\UnitEnum|null $navigationGroup = 'Sistema';
    protected static ?string $modelLabel = 'Configuración';
    protected static ?string $pluralModelLabel = 'Configuraciones';
    public static function form(Schema $form): Schema
    {
        return $form->schema([
            Forms\Components\TextInput::make('key')->required()->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('display_name')->required(),
            Forms\Components\Textarea::make('value'),Forms\Components\Textarea::make('details'),
            Forms\Components\Select::make('type')->options(['text'=>'Texto','textarea'=>'Área de texto','image'=>'Imagen','number'=>'Número'])->default('text'),
            Forms\Components\TextInput::make('order')->numeric()->default(0),
            Forms\Components\TextInput::make('group')->default('general'),
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([Tables\Columns\TextColumn::make('key')->searchable()->sortable(),Tables\Columns\TextColumn::make('display_name'),Tables\Columns\TextColumn::make('value')->limit(50),Tables\Columns\TextColumn::make('group')->sortable()])->actions([\Filament\Actions\EditAction::make()])->defaultSort('group');
    }
    public static function getPages(): array
    {
        return ['index'=>SettingResource\Pages\ListSettings::route('/'),'create'=>SettingResource\Pages\CreateSetting::route('/create'),'edit'=>SettingResource\Pages\EditSetting::route('/{record}/edit')];
    }
}
