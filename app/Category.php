<?php

namespace App;

use FlashHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function array_filter;
use function asset;
use function dd;
use function in_array;
use function redirect;

class Category extends Model
{
    ## Atributos que se pueden asignar al modelo.
    protected $fillable = [
        'name',
        'file_id',
        'description',
        'icon',
        'color',
        'slug',
    ];

    protected $appends = ['urlImage'];

    protected $with = [
        'image',
        'subcategories',
    ];

    /**
     * Relación con las subcategorías asociadas a esta categoría.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id', 'id');
    }

    /**
     * Relación con la tabla "files" que contiene la imagen principal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }

    /**
     * Devuelve la ruta hacia la imagen.
     *
     * @return string
     */
    public function getUrlImageAttribute()
    {
        $url = asset('images/default/default_400x400.jpg');

        if ($this->image && $this->image->name && $this->image->path) {
            $url = $this->image->url;
        }

        return $url;
    }

    /**
     * Procesa el guardado de una request con los datos de una categoría.
     *
     * @param \Illuminate\Http\Request $request
     * @param int|null                  $id  Recibe el id de la categoría.
     *
     * @return \App\Category|null
     */
    public static function store(Request $request, int $id = null)
    {
        ## Cuando recibe id, ya existía la categoría y se busca
        if ($id) {
            $category = self::find($id);
        } else {
            $category = new self();
        }

        ## Compruebo si hay categoría.
        if (! $category) {
            return null;
        }

        ## Filtro elementos que se pueden asignar al modelo.
        $fillable = $category->fillableFromArray($request->all());

        ## Si hay imagen se actualiza o añade.
        if ($request->hasFile('image')) {
            $file = File::store($request->file('image'), 'category', $category->file_id);

            if ($file) {
                $fillable['file_id'] = $file->id;
            }
        }

        ## Guardo los datos.
        try {
            $category = self::updateOrCreate($fillable);
        } catch (\Exception $e) {
            Log::error('Error al crear categoría en modelo Category, método store()');
            Log::error($e);
            return null;
        }

        return $category;
    }
}
