<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentRelated extends Model
{
    protected $table = 'content_related';

    protected $fillable = [
        'content_id',
        'content_related_id'
    ];
}
