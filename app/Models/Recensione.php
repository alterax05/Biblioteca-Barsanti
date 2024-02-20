<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recensione extends Model {

    protected $table = 'recensioni';
    protected $primaryKey = ['ISBN', 'user'];
    public $incrementing = false;
    protected $fillable = ['ISBN', 'user', 'punteggio'];
    public $timestamps = false;
}
