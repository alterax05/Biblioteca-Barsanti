<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autore extends Model
{
    protected $table = 'autori';
    protected $primaryKey = 'id_autore';
    protected $keyType = 'bigint';
    protected $incrementing = true;
    protected $fillable = ['autore'];
    protected $timestamp = false;

    public function belongsScheda() {
        return $this->belongsTo(Scheda_Autore::class, 'id_autore');
    }

    public function belongsLibri() {
        return $this->belongsToMany(Libro::class, 'libri_autori', 'id_autore', 'ISBN');
    }
}
