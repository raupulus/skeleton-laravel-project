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
     * Crea un campo de imagen con cropper 16:9 (landscape).
     * Uso principal: posts, pages, secciones, slides (imagen principal).
     *
     * @param string      $field     Nombre del campo en el modelo (ej: 'image')
     * @param string      $directory Directorio de almacenamiento (ej: 'posts')
     * @param bool        $required  Indica si el campo es obligatorio
     * @param string|null $label     Label personalizado (si null, usa filament.$field)
     * @return FileUpload
     */
    public static function make16x9(
        string $field = 'image',
        string $directory = 'images',
        bool $required = false,
        ?string $label = null
    ): FileUpload {
        $upload = FileUpload::make($field)
            ->label($label ?? __('filament.' . $field))
            ->image()
            ->maxSize(2048)
            ->directory($directory)
            ->imageEditor()
            ->imageAspectRatio('16:9')
            ->automaticallyCropImagesToAspectRatio()
            ->imageEditorAspectRatioOptions([null, '16:9'])
            ->imageEditorMode(2)
            ->columnSpanFull();

        if ($required) {
            $upload->required();
        }

        return $upload;
    }

    /**
     * Crea un campo de imagen con cropper 4:3 (retrato ligero).
     * Uso principal: avatares de usuarios.
     *
     * @param string      $field     Nombre del campo en el modelo (ej: 'avatar')
     * @param string      $directory Directorio de almacenamiento (ej: 'avatars')
     * @param bool        $required  Indica si el campo es obligatorio
     * @param string|null $label     Label personalizado (si null, usa filament.$field)
     * @return FileUpload
     */
    public static function make4x3(
        string $field = 'avatar',
        string $directory = 'avatars',
        bool $required = false,
        ?string $label = null
    ): FileUpload {
        $upload = FileUpload::make($field)
            ->label($label ?? __('filament.' . $field))
            ->image()
            ->maxSize(2048)
            ->directory($directory)
            ->imageEditor()
            ->imageAspectRatio('4:3')
            ->automaticallyCropImagesToAspectRatio()
            ->imageEditorAspectRatioOptions([null, '4:3'])
            ->imageEditorMode(2)
            ->columnSpanFull();

        if ($required) {
            $upload->required();
        }

        return $upload;
    }

    /**
     * Crea un campo de imagen con cropper 9:16 (vertical/portrait).
     * Uso principal: slides verticales.
     *
     * @param string      $field     Nombre del campo en el modelo (ej: 'image_vertical')
     * @param string      $directory Directorio de almacenamiento (ej: 'slides')
     * @param bool        $required  Indica si el campo es obligatorio
     * @param string|null $label     Label personalizado (si null, usa filament.$field)
     * @return FileUpload
     */
    public static function make9x16(
        string $field = 'image_vertical',
        string $directory = 'images',
        bool $required = false,
        ?string $label = null
    ): FileUpload {
        $upload = FileUpload::make($field)
            ->label($label ?? __('filament.' . $field))
            ->image()
            ->maxSize(2048)
            ->directory($directory)
            ->imageEditor()
            ->imageAspectRatio('9:16')
            ->automaticallyCropImagesToAspectRatio()
            ->imageEditorAspectRatioOptions([null, '9:16'])
            ->imageEditorMode(2)
            ->columnSpanFull();

        if ($required) {
            $upload->required();
        }

        return $upload;
    }

    /**
     * Crea un campo de imagen con cropper 8:12 (vertical/portrait).
     * Uso principal: slides verticales.
     *
     * @param string      $field     Nombre del campo en el modelo (ej: 'image_vertical')
     * @param string      $directory Directorio de almacenamiento (ej: 'slides')
     * @param bool        $required  Indica si el campo es obligatorio
     * @param string|null $label     Label personalizado (si null, usa filament.$field)
     * @return FileUpload
     */
    public static function make8x12(
        string $field = 'image_vertical',
        string $directory = 'images',
        bool $required = false,
        ?string $label = null
    ): FileUpload {
        $upload = FileUpload::make($field)
            ->label($label ?? __('filament.' . $field))
            ->image()
            ->maxSize(2048)
            ->directory($directory)
            ->imageEditor()
            ->imageAspectRatio('8:12')
            ->automaticallyCropImagesToAspectRatio()
            ->imageEditorAspectRatioOptions([null, '8:12'])
            ->imageEditorMode(2)
            ->columnSpanFull();

        if ($required) {
            $upload->required();
        }

        return $upload;
    }
}
