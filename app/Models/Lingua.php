<?php

namespace App\Models;

class Lingua extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'lingue';
    protected $primaryKey = 'tag_lingua';
    protected $keyType = 'string';
    protected $incrementing = false;
    protected $timestamps = false;
}
