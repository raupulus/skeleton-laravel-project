<?php
namespace App\Filament\Admin\Resources;
use App\Models\SentEmail;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
class SentEmailResource extends Resource
{
    protected static ?string $model = SentEmail::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';
    protected static string|\UnitEnum|null $navigationGroup = 'Sistema';
    protected static ?string $modelLabel = 'Email enviado';
    protected static ?string $pluralModelLabel = 'Emails enviados';
    public static function canCreate(): bool { return false; }
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('to')->searchable(),Tables\Columns\TextColumn::make('subject')->searchable()->limit(50),
            Tables\Columns\TextColumn::make('mailable_class')->limit(30),Tables\Columns\TextColumn::make('status')->badge()->color(fn ($state) => $state->color()),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y H:i')->sortable(),
        ])->actions([\Filament\Actions\ViewAction::make()])->defaultSort('created_at', 'desc');
    }
    public static function getPages(): array { return ['index'=>SentEmailResource\Pages\ListSentEmails::route('/')]; }
}
