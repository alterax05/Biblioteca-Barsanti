<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornitore extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_tipologia';
    protected $fillable = ['fornitore', 'icona'];
    public $timestamps = false;
}
