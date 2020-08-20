<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    protected $table = 'file_types';
    protected $guarded = [
        'id'
    ];
}
