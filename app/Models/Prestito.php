<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestito extends Model
{
    protected $table = 'prestiti';
    protected $primaryKey = 'id_prestito';
    protected $fillable = ['id_copia', 'id_user', 'ISBN', 'data_inizio', 'data_fine'];
    public $timestamps = false;
}
