<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reparto;

class Genere extends Model
{
    protected $table = 'generi';
    protected $primaryKey = 'id_genere';
    protected $fillable = ['genere'];
    const UPDATED_AT = null;
    const CREATED_AT = null;
}
