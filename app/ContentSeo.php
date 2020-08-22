<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function asset;

class ContentSeo extends Model
{
    protected $table = 'content_seo';

    protected $guarded = ['id'];

    /**
     * Devuelve la ruta hacia la imagen.
     *
     * @return string
     */
    public function getUrlImageAttribute()
    {
        $url = asset('images/default/default_1200x600.jpg');

        if ($this->og_image) {
            $url = asset('storage/' . $this->og_image);
        }

        return $url;
    }
}
