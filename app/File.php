<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use function count;
use function explode;

class File extends Model
{
    protected $table = 'files';
    protected $guarded = [
        'id'
    ];

    /**
     * Almacena y devuelve un archivo recibiendo el objeto de tipo UploadFile.
     * Lo devuelve una vez almacenado.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string                        $path Directorio dónde guardarlo.
     * @param int|null $file_id Id del archivo si
     *                          existiera.
     * @param string $privacity Visibilidad,
     *                          directorio public o private
     *
     * @return mixed
     */
    public static function store(UploadedFile $file, string $path = 'upload',
                                 int $file_id = null, string $privacity = 'public')
    {
        $imageFullPath = $file->store($privacity . '/' . $path);
        $imageNameArray = explode('/', $imageFullPath);
        $imageName = $imageNameArray[count($imageNameArray) - 1];

        ## Obtengo el tipo de archivo o lo creo si no existe.
        $fileType = FileType::updateOrCreate([
            'mime' => $file->getClientMimeType(),
            'extension' => $file->getClientOriginalExtension(),
        ], [
            'type' => 'image',
            'mime' => $file->getClientMimeType(),
            'extension' => $file->getClientOriginalExtension(),
        ]);

        ## Registro el archivo de imagen.
        return self::updateOrCreate([
            'id' => $file_id
        ], [
            'file_type_id' => $fileType->id,
            'size' => $file->getSize(),
            'name' => $imageName,
            'originalname' => $file->getClientOriginalName(),
            'path' => $path,
            'alt' => $file->getClientOriginalName(),
            'title' => $file->getClientOriginalName(),
            'is_private' => false,
        ]);
    }
}
