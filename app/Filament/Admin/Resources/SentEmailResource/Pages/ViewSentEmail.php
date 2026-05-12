<?php

namespace App\Filament\Admin\Resources\SentEmailResource\Pages;

use App\Filament\Admin\Resources\SentEmailResource;
use Filament\Resources\Pages\ViewRecord;

/**
 * Página de detalle (solo lectura) de un email enviado.
 */
class ViewSentEmail extends ViewRecord
{
    protected static string $resource = SentEmailResource::class;
}
