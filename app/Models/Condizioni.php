<?php

namespace App\Models;

class Condizioni extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'condizioni';
    protected $primaryKey = 'id_condizioni';
    protected $keyType = 'tinyint';
    protected $fillable = ['condizioni'];
    public $timestamps = false;
    protected $casts = [
        'id_condizioni' => 'int',
        'condizioni' => 'string'
    ];
}
