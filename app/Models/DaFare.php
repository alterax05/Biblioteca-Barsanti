<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaFare extends Model
{
    protected $table = 'copie_da_fare';
    protected $fillable = ['ISBN'];
    protected $primaryKey = 'id_copia';
    protected $timestamps = false;
}
