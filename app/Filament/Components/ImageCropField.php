<?php

namespace App\Filament\Components;

use Filament\Forms\Components\FileUpload;

/**
 * Clase helper reutilizable para crear campos de imagen con cropper
 * preconfigurado para distintas proporciones de aspecto.
 */
class ImageCropField
{
    /**
     * Tipos MIME seguros permitidos para subida de imágenes (bloquea SVG para evitar Stored XSS).
     *
     * @var array<int, string>
     */
    public const ACCEPTED_MIME_TYPES = [
        'image/jpeg',
        'image/png',
        'image/webp',
    ];

    /**
     * Crea un campo de imagen con cropper 16:9 (landscape).
     * Uso principal: posts, pages, secciones, slides (imagen principal).
     *
     * @param  string  $field  Nombre del campo en el modelo (ej: 'image')
     * @param  string  $directory  Directorio de almacenamiento (ej: 'posts')
     * @param  bool  $required  Indica si el campo es obligatorio
     * @param  string|null  $label  Label personalizado (si null, usa filament.$field)
     * @param  int|string|array<string, int>|null  $columnSpan  Ancho de columna en el grid
     */
    public static function make16x9(
        string $field = 'image',
        string $directory = 'images',
        bool $required = false,
        ?string $label = null,
        int|string|array|null $columnSpan = 'full'
    ): FileUpload {
        return self::configureBaseUpload($field, $directory, '16:9', $required, $label, $columnSpan);
    }

    /**
     * Crea un campo de imagen con cropper 4:3 (retrato ligero).
     * Uso principal: avatares de usuarios.
     *
     * @param  string  $field  Nombre del campo en el modelo (ej: 'avatar')
     * @param  string  $directory  Directorio de almacenamiento (ej: 'avatars')
     * @param  bool  $required  Indica si el campo es obligatorio
     * @param  string|null  $label  Label personalizado (si null, usa filament.$field)
     * @param  int|string|array<string, int>|null  $columnSpan  Ancho de columna en el grid
     */
    public static function make4x3(
        string $field = 'avatar',
        string $directory = 'avatars',
        bool $required = false,
        ?string $label = null,
        int|string|array|null $columnSpan = 'full'
    ): FileUpload {
        return self::configureBaseUpload($field, $directory, '4:3', $required, $label, $columnSpan);
    }

    /**
     * Crea un campo de imagen con cropper 9:16 (vertical/portrait).
     * Uso principal: slides verticales.
     *
     * @param  string  $field  Nombre del campo en el modelo (ej: 'image_vertical')
     * @param  string  $directory  Directorio de almacenamiento (ej: 'slides')
     * @param  bool  $required  Indica si el campo es obligatorio
     * @param  string|null  $label  Label personalizado (si null, usa filament.$field)
     * @param  int|string|array<string, int>|null  $columnSpan  Ancho de columna en el grid
     */
    public static function make9x16(
        string $field = 'image_vertical',
        string $directory = 'images',
        bool $required = false,
        ?string $label = null,
        int|string|array|null $columnSpan = 'full'
    ): FileUpload {
        return self::configureBaseUpload($field, $directory, '9:16', $required, $label, $columnSpan);
    }

    /**
     * Crea un campo de imagen con cropper 8:12 (vertical/portrait).
     * Uso principal: slides verticales.
     *
     * @param  string  $field  Nombre del campo en el modelo (ej: 'image_vertical')
     * @param  string  $directory  Directorio de almacenamiento (ej: 'slides')
     * @param  bool  $required  Indica si el campo es obligatorio
     * @param  string|null  $label  Label personalizado (si null, usa filament.$field)
     * @param  int|string|array<string, int>|null  $columnSpan  Ancho de columna en el grid
     */
    public static function make8x12(
        string $field = 'image_vertical',
        string $directory = 'images',
        bool $required = false,
        ?string $label = null,
        int|string|array|null $columnSpan = 'full'
    ): FileUpload {
        return self::configureBaseUpload($field, $directory, '8:12', $required, $label, $columnSpan);
    }

    /**
     * Configura una instancia base de FileUpload con validación estricta de MIME, disco público y cropper.
     *
     * @param  int|string|array<string, int>|null  $columnSpan
     */
    protected static function configureBaseUpload(
        string $field,
        string $directory,
        string $aspectRatio,
        bool $required,
        ?string $label,
        int|string|array|null $columnSpan
    ): FileUpload {
        $upload = FileUpload::make($field)
            ->label($label ?? __('filament.'.$field))
            ->disk('public')
            ->visibility('public')
            ->image()
            ->acceptedFileTypes(self::ACCEPTED_MIME_TYPES)
            ->maxSize(2048)
            ->directory($directory)
            ->imageEditor()
            ->imageAspectRatio($aspectRatio)
            ->automaticallyCropImagesToAspectRatio()
            ->imageEditorAspectRatioOptions([null, $aspectRatio])
            ->imageEditorMode(2);

        if ($columnSpan === 'full') {
            $upload->columnSpanFull();
        } elseif ($columnSpan !== null) {
            $upload->columnSpan($columnSpan);
        }

        if ($required) {
            $upload->required();
        }

        return $upload;
    }
}
