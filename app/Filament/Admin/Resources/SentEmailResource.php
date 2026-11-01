<?php

namespace App\Filament\Admin\Resources;

use App\Enums\EmailStatus;
use App\Models\SentEmail;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * Recurso Filament para gestionar los emails enviados en el panel admin.
 */
class SentEmailResource extends Resource
{
    protected static ?string $model = SentEmail::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static ?int $navigationSort = 8;

    /**
     * Devuelve el label del modelo traducido.
     */
    public static function getModelLabel(): string
    {
        return __('filament.sent_email');
    }

    /**
     * Devuelve el label plural del modelo traducido.
     */
    public static function getPluralModelLabel(): string
    {
        return __('filament.sent_emails');
    }

    /**
     * Devuelve el grupo de navegación traducido.
     */
    public static function getNavigationGroup(): ?string
    {
        return __('filament.nav_system');
    }

    /**
     * No se permite crear emails enviados manualmente.
     */
    public static function canCreate(): bool
    {
        return false;
    }

    /**
     * Define la infolist para la vista de detalle del email enviado.
     * NOTA: En Filament 5 la firma es infolist(Schema $schema): Schema.
     */
    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            TextEntry::make('to')
                ->label(__('filament.to')),
            TextEntry::make('from')
                ->label(__('filament.from')),
            TextEntry::make('subject')
                ->label(__('filament.subject'))
                ->columnSpanFull(),
            TextEntry::make('mailable_class')
                ->label(__('filament.mailable_class')),
            TextEntry::make('status')
                ->label(__('filament.status'))
                ->badge(),
            TextEntry::make('body')
                ->label(__('filament.body'))
                ->html()
                ->columnSpanFull()
                ->formatStateUsing(fn ($state) => $state
                    ? '<div class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 p-4 border border-gray-200 dark:border-white/10 rounded-lg max-h-[600px] overflow-auto">'.$state.'</div>'
                    : ''
                ),
            TextEntry::make('error_message')
                ->label(__('filament.error_message'))
                ->columnSpanFull()
                ->visible(fn ($record) => ! empty($record->error_message)),
            TextEntry::make('metadata')
                ->label(__('filament.metadata'))
                ->columnSpanFull()
                ->visible(fn ($record) => ! empty($record->metadata)),
            TextEntry::make('created_at')
                ->label(__('filament.created_at'))
                ->dateTime('d/m/Y H:i:s'),
        ]);
    }

    /**
     * Define la tabla del recurso.
     */
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('to')
                ->label(__('filament.to'))
                ->searchable()
                ->limit(35),
            Tables\Columns\TextColumn::make('subject')
                ->label(__('filament.subject'))
                ->searchable()
                ->limit(50)
                ->toggleable(),
            Tables\Columns\TextColumn::make('mailable_class')
                ->label(__('filament.mailable_class'))
                ->limit(30)
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('status')
                ->label(__('filament.status'))
                ->badge(),
            Tables\Columns\TextColumn::make('created_at')
                ->label(__('filament.created_at'))
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(),
        ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('filament.status'))
                    ->options(EmailStatus::class),
            ])
            ->actions([ViewAction::make()])
            ->defaultSort('created_at', 'desc');
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => SentEmailResource\Pages\ListSentEmails::route('/'),
            'view' => SentEmailResource\Pages\ViewSentEmail::route('/{record}'),
        ];
    }
}
