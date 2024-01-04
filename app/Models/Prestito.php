<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestito extends Model
{
    protected $table = 'prestiti';
    protected $primaryKey = 'id_prestito';
    protected $fillable = ['libro', 'user'];
    const UPDATED_AT = null;
    const CREATED_AT = null;
}
