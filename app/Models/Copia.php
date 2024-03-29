<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Editore;
use Illuminate\Support\Facades\DB;

class Copia extends Model
{
    protected $table = 'copie';
    protected $primaryKey = 'id_copia';
    protected $fillable = ['num_copia','ISBN', 'scaffale', 'ripiano', 'prestati', 'condizioni', 'reparto'];
    const UPDATED_AT = null;

    public function belongsLibro() {
        return $this->belongsTo(Libro::class, 'ISBN');
    }

    public function belongsEditore() {
        return $this->belongsTo(Editore::class, 'editore');
    }

    public function belongsGenere() {
        return $this->belongsTo(Genere::class, 'genere');
    }

    public function belongsCondizioni() {
        return $this->belongsTo(Condizioni::class, 'condizioni');
    }

    public function belongsAutori() {
        return $this->belongsToMany(Autore::class, 'libri_autori', 'ISBN' ,'id_autore');
    }

    public function belongsLingua() {
        return $this->belongsTo(Lingua::class, 'lingua');
    }
}
