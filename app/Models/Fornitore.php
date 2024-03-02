<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornitore extends Model
{
    protected $primaryKey = 'id_fornitore';
    protected $fillable = ['fornitore', 'icona'];
    public $timestamps = false;
}
