<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nazione extends Model
{
    protected $table = 'nazioni';
    protected $primaryKey = 'id_nazione';
    protected $keyType = 'string';
    // se si modifica incrementing o timestamp esse devono essere dichiarate come public
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['nazione', 'tag'];
}
