<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recensione extends Model {

    protected $table = 'recensioni';
    protected $primaryKey = 'ISBN';
    public $incrementing = false;
    protected $fillable = ['ISBN', 'user', 'punteggio'];
    const UPDATED_AT = null;
    const CREATED_AT = null;
}
