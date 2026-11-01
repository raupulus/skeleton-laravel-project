<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Controlador para la descarga segura de archivos de log del sistema.
 * Solo accesible para usuarios con rol admin o superadmin.
 */
class LogDownloadController extends Controller
{
    /**
     * Descarga un archivo de log de forma segura.
     *
     * @param  string  $filename  Nombre del archivo de log
     */
    public function download(string $filename): BinaryFileResponse
    {
        // Verificar que el usuario está activo y es administrador
        $user = auth()->user();
        abort_unless($user && $user->is_active && $user->isAdmin(), 403);

        $path = storage_path('logs/'.basename($filename));
        $realPath = realpath($path);
        $logsDir = realpath(storage_path('logs'));

        // Prevenir path traversal
        abort_unless($realPath && str_starts_with($realPath, $logsDir), 403);
        abort_unless(File::exists($realPath), 404);

        return response()->download($realPath);
    }
}
