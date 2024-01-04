<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheda_Autore extends Model
{
    protected $table = 'schede_autori';
    protected $primaryKey = 'id_autore';
    protected $fillable = ['avatar', 'descrizione'];
    const UPDATED_AT = null;
    const CREATED_AT = null;

    public function belongsAutore() {
        return $this->belongsTo(Autore::class, 'id_autore');
    }

    public function belongsNazione() {
        return $this->belongsTo(Nazione::class, 'id_nazione');
    }
}
