<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use VanOns\Laraberg\Models\Gutenbergable;

use function asset;
use function route;

class Content extends Model
{
    use Gutenbergable;

    protected $fillable = [
        'user_id',
        'status_id',
        'type_id',
        'file_id',
        'title',
        'slug',
        'excerpt',
        'body'
    ];

    protected $appends = ['urlImage'];

    /**
     * Devuelve la relación con el autor/usuario que ha creado el contenido.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Devuelve la relación con el autor/usuario que ha creado el contenido.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->author();
    }

    /**
     * Devuelve la relación con el estado del post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(ContentStatus::class, 'status_id', 'id');
    }

    /**
     * Devuelve la relación al tipo de contenido.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ContentType::class, 'type_id', 'id');
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
     * Relación con los colaboradores asociados al contenido.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function collaborators()
    {
        return $this->hasMany(ContentContributor::class, 'content_id', 'id');
    }

    /**
     * Relación con las galerías asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galleries()
    {
        return $this->hasMany(ContentGallery::class, 'content_id', 'id');
    }

    /**
     * Relación al seo asociado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function seo()
    {
        return $this->hasOne(ContentSeo::class, 'content_id', 'id');
    }

    /**
     * Relación con las subcategorías asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(ContentSubcategory::class, 'content_id', 'id');
    }

    /**
     * Relación con las etiquetas asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->hasMany(ContentTag::class, 'content_id', 'id');
    }

    /**
     * Devuelve la ruta hacia la imagen.
     *
     * @return string
     */
    public function getUrlImageAttribute()
    {
        $url = asset('images/default/default_1200x600.jpg');

        if ($this->image && $this->image->name && $this->image->path) {
            $url = asset('storage/' . $this->image->path . '/' . $this->image->name);
        }

        return $url;
    }

    /**
     * Devuelve la url para su previsualización.
     */
    public function getUrlPreviewAttribute()
    {

    }

    /**
     * Devuelve la url para ver un contenido publicado.
     * Los administradores, propietario y colaboradores también pueden ver
     * borradores.
     */
    public function getUrlAttribute()
    {
        return url('TEMPORAL/URL/PAGINA/' . $this->slug);
    }

    /**
     * Devuelve la url para editar un contenido.
     *
     * @return string Devuelve una cadena con la ruta para editar este
     *                contenido.
     */
    public function getUrlEditAttribute()
    {
        return route('panel.content.edit', ['content' => $this->id]);
    }
}
