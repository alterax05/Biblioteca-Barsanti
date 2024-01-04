<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prenotazione extends Model {

    protected $table = 'prenotazioni';
    protected $primaryKey = 'id_prenotazione';
    protected $fillable = ['user', 'id_copia'];
    const UPDATED_AT = null;
}
