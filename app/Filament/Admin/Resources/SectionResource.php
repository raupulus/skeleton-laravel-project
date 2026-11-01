<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Components\ImageCropField;
use App\Models\Section;
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
use Illuminate\Validation\Rules\Unique;

/**
 * Recurso Filament para gestionar las secciones dinámicas del frontend.
 */
class SectionResource extends Resource
{
    protected static ?string $model = Section::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?int $navigationSort = 6;

    /**
     * Devuelve el label del modelo traducido.
     */
    public static function getModelLabel(): string
    {
        return __('filament.section');
    }

    /**
     * Devuelve el label plural del modelo traducido.
     */
    public static function getPluralModelLabel(): string
    {
        return __('filament.sections');
    }

    /**
     * Devuelve el grupo de navegación traducido.
     */
    public static function getNavigationGroup(): ?string
    {
        return __('filament.nav_frontend');
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
            // Imagen con cropper 16:9 — primer campo, ancho completo
            ImageCropField::make16x9('image', 'sections'),

            // Traducciones con labels correctos
            Tabs::make(__('filament.translations'))->tabs([
                Tab::make(__('filament.tab_spanish'))->schema([
                    Forms\Components\TextInput::make('title.es')->label(__('filament.title').' (ES)')->required()->maxLength(255),
                    Forms\Components\Textarea::make('description.es')->label(__('filament.description').' (ES)')->maxLength(1000),
                    Forms\Components\RichEditor::make('content.es')->label(__('filament.content').' (ES)'),
                ]),
                Tab::make(__('filament.tab_english'))->schema([
                    Forms\Components\TextInput::make('title.en')->label(__('filament.title').' (EN)')->maxLength(255),
                    Forms\Components\Textarea::make('description.en')->label(__('filament.description').' (EN)')->maxLength(1000),
                    Forms\Components\RichEditor::make('content.en')->label(__('filament.content').' (EN)'),
                ]),
            ])->columnSpanFull(),

            // Slug debajo del título, ancho completo
            Forms\Components\TextInput::make('slug')
                ->label(__('filament.slug'))
                ->maxLength(255)
                ->unique(ignoreRecord: true, modifyRuleUsing: fn (Unique $rule) => $rule->whereNull('deleted_at'))
                ->columnSpanFull(),

            // Zone y Order con labels traducidos
            Forms\Components\TextInput::make('zone')
                ->label(__('filament.zone'))
                ->required()
                ->maxLength(100)
                ->datalist(fn () => Section::query()
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
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('slug')
                ->label(__('filament.slug'))
                ->searchable()
                ->sortable()
                ->limit(35)
                ->toggleable(),
            Tables\Columns\TextColumn::make('zone')
                ->label(__('filament.zone'))
                ->sortable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('title')
                ->label(__('filament.title'))
                ->searchable()
                ->limit(45),
            Tables\Columns\TextColumn::make('order')
                ->label(__('filament.order'))
                ->sortable()
                ->toggleable(),
        ])
            ->filters([
                Tables\Filters\SelectFilter::make('zone')
                    ->label(__('filament.zone'))
                    ->options(fn () => Section::query()->select('zone')->distinct()->pluck('zone', 'zone')->toArray()),
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
            'index' => SectionResource\Pages\ListSections::route('/'),
            'create' => SectionResource\Pages\CreateSection::route('/create'),
            'edit' => SectionResource\Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
