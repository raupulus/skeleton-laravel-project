<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultModel extends Model
{
    protected $guarded = [
        'id',
    ];
}
