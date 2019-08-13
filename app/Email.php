<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Emails
 *
 * Clase para gestionar el guardado de los correos en la base de datos.
 *
 * @package App
 */
class Email extends Model
{
    protected $table = 'emails';

    protected $guarded = [
        'id',
    ];
}
