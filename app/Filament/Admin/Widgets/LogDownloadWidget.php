<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\File;

/**
 * Widget del Dashboard Admin que muestra información sobre el último log de errores
 * y permite descargarlo directamente. También enlaza al módulo de logs.
 */
class LogDownloadWidget extends Widget
{
    /** @var int Orden del widget en el dashboard — reemplaza FilamentInfoWidget en posición -2 */
    protected static ?int $sort = -2;

    /** @var string Vista del widget */
    protected string $view = 'filament.admin.widgets.log-download';

    /**
     * Solo los administradores pueden ver este widget.
     */
    public static function canView(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    /**
     * Devuelve información sobre el último archivo de log.
     *
     * @return array{name: string|null, size: string|null, modified: string|null, exists: bool}
     */
    public function getLatestLog(): array
    {
        $logPath = storage_path('logs');

        if (! File::isDirectory($logPath)) {
            return ['name' => null, 'size' => null, 'modified' => null, 'exists' => false];
        }

        $files = collect(File::files($logPath))
            ->filter(fn ($file) => $file->getExtension() === 'log')
            ->sortByDesc(fn ($file) => $file->getMTime());

        if ($files->isEmpty()) {
            return ['name' => null, 'size' => null, 'modified' => null, 'exists' => false];
        }

        $latest = $files->first();

        return [
            'name' => $latest->getFilename(),
            'size' => number_format($latest->getSize() / 1048576, 2).' MB',
            'modified' => date('d/m/Y H:i', $latest->getMTime()),
            'exists' => true,
        ];
    }
}
