<?php

namespace App\Filament\Admin\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Computed;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Página para visualizar y descargar los logs de Laravel desde el panel admin.
 */
class ViewLogs extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-magnifying-glass';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.admin.pages.view-logs';

    public ?string $selectedLog = null;

    public ?string $logContent = null;

    /**
     * Devuelve el grupo de navegación traducido.
     */
    public static function getNavigationGroup(): ?string
    {
        return __('filament.nav_actions');
    }

    /**
     * Devuelve el label de navegación traducido.
     */
    public static function getNavigationLabel(): string
    {
        return __('filament.view_logs');
    }

    /**
     * Devuelve el título de la página traducido.
     */
    public function getTitle(): string
    {
        return __('filament.view_logs');
    }

    /**
     * Devuelve la lista de archivos de log ordenados por fecha descendente.
     */
    #[Computed]
    public function logFiles(): Collection
    {
        $logPath = storage_path('logs');

        if (! File::isDirectory($logPath)) {
            return collect();
        }

        return collect(File::files($logPath))
            ->filter(fn ($file) => $file->getExtension() === 'log')
            ->sortByDesc(fn ($file) => $file->getMTime())
            ->values()
            ->map(fn ($file) => [
                'name' => $file->getFilename(),
                'size' => number_format($file->getSize() / 1024, 2).' KB',
                'modified' => date('d/m/Y H:i:s', $file->getMTime()),
            ]);
    }

    /**
     * Carga el contenido de un archivo de log para mostrarlo en el modal.
     */
    public function viewLog(string $filename): void
    {
        $path = storage_path('logs/'.basename($filename));

        if (! File::exists($path)) {
            Notification::make()->title(__('filament.view_logs_not_found'))->danger()->send();

            return;
        }

        $this->selectedLog = $filename;

        // Limitar a las últimas 500 líneas para evitar problemas de memoria
        $lines = file($path);
        $lastLines = array_slice($lines, -500);
        $this->logContent = implode('', $lastLines);
    }

    /**
     * Descarga un archivo de log usando streamDownload (compatible con Livewire).
     */
    public function downloadLog(string $filename): ?StreamedResponse
    {
        $path = storage_path('logs/'.basename($filename));

        if (! File::exists($path)) {
            Notification::make()->title(__('filament.view_logs_not_found'))->danger()->send();

            return null;
        }

        // Seguridad: verificar que el archivo está dentro del directorio de logs
        $realPath = realpath($path);
        $logsDir = realpath(storage_path('logs'));
        if (! $realPath || ! str_starts_with($realPath, $logsDir)) {
            abort(403);
        }

        return response()->streamDownload(function () use ($realPath) {
            echo file_get_contents($realPath);
        }, $filename);
    }

    /**
     * Cierra el modal del log.
     */
    public function closeLogModal(): void
    {
        $this->selectedLog = null;
        $this->logContent = null;
    }
}
