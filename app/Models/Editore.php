<?php

namespace App\Models;

class Editore extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'editori';
    protected $primaryKey = 'id_editore';
    protected $fillable = ['editore'];
    protected $timestamps = false;
}
