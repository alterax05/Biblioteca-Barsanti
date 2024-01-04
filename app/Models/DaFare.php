<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaFare extends Model
{
    protected $table = 'copie_da_fare';
    protected $fillable = ['ISBN'];
    public const UPDATED_AT = null;
}
