<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reparto extends Model
{
    protected $table = 'reparti';
    protected $primaryKey = 'id_reparto';
    protected $fillable = ['reparto', 'icon'];
}
