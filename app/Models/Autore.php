<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autore extends Model
{
    protected $table = 'autori';
    protected $primaryKey = 'id_autore';
    protected $fillable = ['autore'];
    const UPDATED_AT = null;
    const CREATED_AT = null;

    public function belongsScheda() {
        return $this->belongsTo(Scheda_Autore::class, 'id_autore');
    }
}
