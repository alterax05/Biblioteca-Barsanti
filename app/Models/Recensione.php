<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recensione extends Model {

    protected $table = 'recensioni';
    public $incrementing = false;
    protected $fillable = ['ISBN', 'user', 'punteggio'];
    protected $primaryKey = 'user';
    public $timestamps = false;
}
