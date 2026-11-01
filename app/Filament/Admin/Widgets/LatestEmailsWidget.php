<?php

namespace App\Filament\Admin\Widgets;

use App\Models\SentEmail;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

/**
 * Widget que muestra los últimos 5 emails enviados por la plataforma
 * en el Dashboard Admin. Solo lectura.
 */
class LatestEmailsWidget extends BaseWidget
{
    /** @var int Orden del widget en el dashboard */
    protected static ?int $sort = 3;

    /** @var int|string|array Ancho de columna del widget */
    protected int|string|array $columnSpan = 'full';

    /**
     * Solo los administradores pueden ver este widget.
     */
    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    /**
     * Devuelve el heading traducido del widget.
     */
    public function getHeading(): ?string
    {
        return __('filament.latest_emails');
    }

    /**
     * Configura la tabla del widget con los últimos emails.
     *
     * @param  Table  $table  Instancia de la tabla de Filament
     * @return Table Tabla configurada
     */
    public function table(Table $table): Table
    {
        return $table
            ->query(SentEmail::query()->latest()->limit(5))
            ->columns([
                TextColumn::make('to')
                    ->label(__('filament.to'))
                    ->limit(30),
                TextColumn::make('subject')
                    ->label(__('filament.subject'))
                    ->limit(50)
                    ->toggleable(),
                TextColumn::make('status')
                    ->label(__('filament.status'))
                    ->badge(),
                TextColumn::make('created_at')
                    ->label(__('filament.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(),
            ])
            ->paginated(false);
    }
}
