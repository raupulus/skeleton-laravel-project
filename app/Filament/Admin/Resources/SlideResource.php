<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Components\ImageCropField;
use App\Models\Slide;
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

/**
 * Recurso Filament para gestionar los slides (carruseles) en el panel admin.
 */
class SlideResource extends Resource
{
    protected static ?string $model = Slide::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static ?int $navigationSort = 5;

    /**
     * Devuelve el label del modelo traducido.
     */
    public static function getModelLabel(): string
    {
        return __('filament.slide');
    }

    /**
     * Devuelve el label plural del modelo traducido.
     */
    public static function getPluralModelLabel(): string
    {
        return __('filament.slides');
    }

    /**
     * Devuelve el grupo de navegación traducido.
     */
    public static function getNavigationGroup(): ?string
    {
        return __('filament.nav_media');
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

    public static function form(Schema $form): Schema
    {
        return $form->schema([
            // 1. Imagen principal (16:9) e Imagen vertical (8:12) lado a lado en escritorio ([BRESP-07])
            ImageCropField::make16x9('image', 'slides', required: true, columnSpan: ['default' => 1, 'lg' => 1]),
            ImageCropField::make8x12('image_vertical', 'slides', columnSpan: ['default' => 1, 'lg' => 1]),

            // 2. Traducciones con labels correctos
            Tabs::make(__('filament.translations'))->tabs([
                Tab::make(__('filament.tab_spanish'))->schema([
                    Forms\Components\TextInput::make('title.es')->label(__('filament.title').' (ES)')->maxLength(255),
                    Forms\Components\Textarea::make('content.es')->label(__('filament.content').' (ES)')->maxLength(1000),
                ]),
                Tab::make(__('filament.tab_english'))->schema([
                    Forms\Components\TextInput::make('title.en')->label(__('filament.title').' (EN)')->maxLength(255),
                    Forms\Components\Textarea::make('content.en')->label(__('filament.content').' (EN)')->maxLength(1000),
                ]),
            ])->columnSpanFull(),

            // 3. Campos adicionales con labels traducidos y validación de longitud
            Forms\Components\TextInput::make('url')
                ->label(__('filament.url'))
                ->url()
                ->maxLength(255),
            Forms\Components\TextInput::make('zone')
                ->label(__('filament.zone'))
                ->required()
                ->maxLength(100)
                ->datalist(fn () => Slide::query()
                    ->select('zone')
                    ->distinct()
                    ->whereNotNull('zone')
                    ->pluck('zone')
                    ->toArray()
                ),
            Forms\Components\TextInput::make('order')
                ->label(__('filament.order'))
                ->numeric()
                ->required()
                ->default(0),
            Forms\Components\Toggle::make('is_active')
                ->label(__('filament.is_active'))
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')
                ->label(__('filament.image'))
                ->disk('public')
                ->height(40),
            Tables\Columns\TextColumn::make('title')
                ->label(__('filament.title'))
                ->searchable()
                ->limit(40),
            Tables\Columns\TextColumn::make('zone')
                ->label(__('filament.zone'))
                ->sortable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('order')
                ->label(__('filament.order'))
                ->sortable()
                ->toggleable(),
            Tables\Columns\IconColumn::make('is_active')
                ->label(__('filament.is_active'))
                ->boolean(),
        ])
            ->filters([
                Tables\Filters\SelectFilter::make('zone')
                    ->label(__('filament.zone'))
                    ->options(fn () => Slide::query()->select('zone')->distinct()->pluck('zone', 'zone')->toArray()),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label(__('filament.is_active')),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                    RestoreAction::make(),
                    ForceDeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
                RestoreBulkAction::make(),
                ForceDeleteBulkAction::make(),
            ])
            ->defaultSort('zone');
    }

    /** @return array<string, PageRegistration> */
    public static function getPages(): array
    {
        return [
            'index' => SlideResource\Pages\ListSlides::route('/'),
            'create' => SlideResource\Pages\CreateSlide::route('/create'),
            'edit' => SlideResource\Pages\EditSlide::route('/{record}/edit'),
        ];
    }
}
