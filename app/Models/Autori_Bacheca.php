<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autori_Bacheca extends Model
{
    protected $table = 'autori_bacheca';
    protected $primaryKey = 'id_autore';
    public $timestamps = true;
    public $incrementing = false;
    const UPDATED_AT = null;
    protected $fillable = [
        'id_autore',
        'subtitle',
        'created_at',
    ];
}