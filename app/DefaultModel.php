<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultModel extends Model
{
    protected $guarded = [
        'id',
    ];

    /**
     * Procesa el guardado del modelo contemplando posibles errores en el
     * proceso.
     *
     * @return bool
     */
    public function store()
    {
        return $this->save();
    }
}
