<?php

namespace App\Console\Commands;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\MarkdownConverter;

/**
 * Comando para generar PDFs de los manuales de la plataforma.
 *
 * Lee los archivos markdown de cada subdirectorio en docs/manual/
 * y genera un PDF por cada directorio (role).
 */
class GenerateManualPdf extends Command
{
    /**
     * Nombre y firma del comando.
     *
     * @var string
     */
    protected $signature = 'manual:generate-pdf';

    /**
     * Descripción del comando.
     *
     * @var string
     */
    protected $description = 'Genera un PDF por cada role a partir de los manuales en docs/manual/';

    /**
     * Títulos descriptivos para cada directorio/role.
     *
     * @var array<string, string>
     */
    private array $roleTitles = [
        'admin' => 'Manual del Administrador',
        'user_backend' => 'Manual del Panel de Usuario',
        'user' => 'Manual del Usuario',
    ];

    /**
     * Ejecutar el comando.
     */
    public function handle(): int
    {
        $manualBasePath = base_path('docs/manual');

        if (! File::isDirectory($manualBasePath)) {
            $this->error('No se encontró el directorio docs/manual/');

            return Command::FAILURE;
        }

        // Obtener todos los subdirectorios (cada uno es un role)
        $directories = collect(File::directories($manualBasePath))->sort()->values();

        if ($directories->isEmpty()) {
            $this->error('No se encontraron subdirectorios en docs/manual/');

            return Command::FAILURE;
        }

        $this->info('');
        $this->info('╔══════════════════════════════════════════════╗');
        $this->info('║   Generación de PDFs de manuales            ║');
        $this->info('╚══════════════════════════════════════════════╝');
        $this->info('');

        // Configurar el conversor de Markdown con soporte para tablas
        $converter = $this->createMarkdownConverter();

        $generatedFiles = [];

        foreach ($directories as $directory) {
            $dirName = basename($directory);
            $title = $this->roleTitles[$dirName] ?? ucfirst(str_replace('_', ' ', $dirName));

            $this->info("📄 Procesando: {$title} ({$dirName})");

            // Obtener archivos markdown ordenados
            $markdownFiles = collect(File::files($directory))
                ->filter(fn ($file) => $file->getExtension() === 'md')
                ->sortBy(fn ($file) => $file->getFilename())
                ->values();

            if ($markdownFiles->isEmpty()) {
                $this->warn("   ⚠ No se encontraron archivos .md en {$dirName}/");

                continue;
            }

            // Convertir cada archivo markdown a HTML
            $sectionsHtml = [];

            foreach ($markdownFiles as $file) {
                $this->line("   ├── {$file->getFilename()}");

                $markdownContent = File::get($file->getPathname());
                $htmlContent = $converter->convert($markdownContent)->getContent();

                $sectionsHtml[] = $htmlContent;
            }

            $this->line("   └── {$markdownFiles->count()} archivos procesados");

            // Generar el HTML completo del documento
            $fullHtml = $this->buildDocumentHtml($title, $sectionsHtml);

            // Generar el PDF
            $pdfPath = $manualBasePath.'/'.$dirName.'.pdf';

            $pdf = Pdf::loadHTML($fullHtml)
                ->setPaper('a4', 'portrait')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', false)
                ->setOption('defaultFont', 'DejaVu Sans')
                ->setOption('dpi', 150)
                ->setOption('margin-top', 20)
                ->setOption('margin-bottom', 20);

            $pdf->save($pdfPath);

            $generatedFiles[] = $pdfPath;
            $this->info("   ✅ PDF generado: docs/manual/{$dirName}.pdf");
            $this->info('');
        }

        $this->info('══════════════════════════════════════════════');
        $count = count($generatedFiles);
        $this->info("✅ {$count} PDF(s) generado(s) correctamente:");

        foreach ($generatedFiles as $file) {
            $this->line('   📁 '.str_replace(base_path().'/', '', $file));
        }

        $this->info('');

        return Command::SUCCESS;
    }

    /**
     * Crear el conversor de Markdown con extensiones.
     */
    private function createMarkdownConverter(): MarkdownConverter
    {
        $config = [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ];

        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new TableExtension);

        return new MarkdownConverter($environment);
    }

    /**
     * Construir el HTML completo del documento PDF.
     *
     * @param  string  $title  Título del documento
     * @param  array<int, string>  $sectionsHtml  Secciones HTML convertidas desde markdown
     */
    private function buildDocumentHtml(string $title, array $sectionsHtml): string
    {
        $date = now()->format('d/m/Y');
        $appName = config('app.name', 'Skeleton Laravel Project');

        // Unir secciones con separador visual
        $contentHtml = implode("\n<div class=\"section-separator\"></div>\n", $sectionsHtml);

        return <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
    <style>
        /* === Reset y base === */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #1a1a2e;
            background-color: #ffffff;
        }

        /* === Portada === */
        .cover-page {
            page-break-after: always;
            text-align: center;
            padding-top: 200px;
        }

        .cover-page .app-name {
            font-size: 14pt;
            color: #6366f1;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 30px;
        }

        .cover-page .title {
            font-size: 28pt;
            font-weight: bold;
            color: #1e1b4b;
            margin-bottom: 20px;
            line-height: 1.3;
        }

        .cover-page .subtitle {
            font-size: 13pt;
            color: #64748b;
            margin-bottom: 60px;
        }

        .cover-page .divider {
            width: 120px;
            height: 4px;
            background-color: #6366f1;
            margin: 0 auto 40px auto;
        }

        .cover-page .date {
            font-size: 11pt;
            color: #94a3b8;
        }

        /* === Encabezado y pie de página === */
        .header {
            text-align: right;
            font-size: 8pt;
            color: #94a3b8;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
            margin-bottom: 30px;
        }

        /* === Separador de secciones === */
        .section-separator {
            page-break-before: always;
            margin: 0;
            padding: 0;
        }

        /* === Contenido de sección === */
        .section-content {
            padding: 0 10px;
        }

        /* === Encabezados === */
        h1 {
            font-size: 22pt;
            font-weight: bold;
            color: #1e1b4b;
            margin-top: 10px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 3px solid #6366f1;
        }

        h2 {
            font-size: 16pt;
            font-weight: bold;
            color: #312e81;
            margin-top: 35px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #c7d2fe;
        }

        h3 {
            font-size: 13pt;
            font-weight: bold;
            color: #4338ca;
            margin-top: 28px;
            margin-bottom: 12px;
        }

        h4 {
            font-size: 11pt;
            font-weight: bold;
            color: #4f46e5;
            margin-top: 22px;
            margin-bottom: 10px;
        }

        /* === Párrafos === */
        p {
            margin-bottom: 14px;
            text-align: justify;
        }

        /* === Listas === */
        ul, ol {
            margin-bottom: 16px;
            padding-left: 28px;
        }

        li {
            margin-bottom: 6px;
        }

        /* === Tablas === */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            margin-bottom: 24px;
            font-size: 10pt;
        }

        thead tr {
            background-color: #4338ca;
            color: #ffffff;
        }

        th {
            padding: 10px 12px;
            text-align: left;
            font-weight: bold;
            font-size: 9.5pt;
        }

        td {
            padding: 9px 12px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        tbody tr:hover {
            background-color: #eef2ff;
        }

        /* === Código === */
        code {
            background-color: #f1f5f9;
            color: #be185d;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'DejaVu Sans Mono', 'Courier New', monospace;
            font-size: 9.5pt;
        }

        pre {
            background-color: #1e293b;
            color: #e2e8f0;
            padding: 16px 20px;
            border-radius: 6px;
            margin-top: 10px;
            margin-bottom: 20px;
            overflow-x: auto;
            font-size: 9pt;
            line-height: 1.5;
        }

        pre code {
            background-color: transparent;
            color: #e2e8f0;
            padding: 0;
            font-size: 9pt;
        }

        /* === Blockquotes (notas) === */
        blockquote {
            border-left: 4px solid #6366f1;
            background-color: #eef2ff;
            padding: 14px 18px;
            margin: 16px 0 20px 0;
            font-size: 10.5pt;
            color: #3730a3;
        }

        blockquote p {
            margin-bottom: 6px;
        }

        blockquote p:last-child {
            margin-bottom: 0;
        }

        /* === Líneas horizontales === */
        hr {
            border: none;
            border-top: 1px solid #cbd5e1;
            margin: 30px 0;
        }

        /* === Negrita y cursiva === */
        strong {
            font-weight: bold;
            color: #1e1b4b;
        }

        em {
            font-style: italic;
            color: #475569;
        }

        /* === Enlaces === */
        a {
            color: #4f46e5;
            text-decoration: underline;
        }

        /* === Emojis y símbolos === */
        .emoji {
            font-style: normal;
        }

        /* === Pie de documento === */
        .document-footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            font-size: 9pt;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <!-- Portada -->
    <div class="cover-page">
        <div class="app-name">{$appName}</div>
        <div class="divider"></div>
        <div class="title">{$title}</div>
        <div class="subtitle">Documentación completa de uso de la plataforma</div>
        <div class="date">Generado el {$date}</div>
    </div>

    <!-- Contenido del manual -->
    {$contentHtml}

    <!-- Pie del documento -->
    <div class="document-footer">
        {$appName} — {$title} — Generado el {$date}
    </div>

</body>
</html>
HTML;
    }
}
