<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheda_Autore extends Model
{
    protected $table = 'schede_autori';
    protected $primaryKey = 'id_autore';
    protected $fillable = ['location','id_nazione','anno_nascita','anno_morte','avatar', 'descrizione', 'nobel'];
    public $timestamps = false;

    public function belongsAutore() {
        return $this->belongsTo(Autore::class, 'id_autore');
    }

    public function belongsNazione() {
        return $this->belongsTo(Nazione::class, 'id_nazione');
    }
}
