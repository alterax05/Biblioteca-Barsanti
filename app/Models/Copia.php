<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Editore;
use Illuminate\Support\Facades\DB;

class Copia extends Model
{
    protected $table = 'copie';
    protected $primaryKey = 'id_libro';
    protected $fillable = ['id_libro','ISBN', 'scaffale', 'ripiano', 'prestati', 'condizioni', 'reparto'];
    const UPDATED_AT = null;

    public static function belongsCovers($libri) {
        foreach ($libri as $libro) {
            $cover = Cover::find($libro->id_libro);
            $libro->cover = ($cover != null)? $cover->thumbnail : "";
        }

        return $libri;
    }

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
        return $this->hasMany(Libri_Autori::class, 'ISBN');
    }

    public function belongsLingua() {
        return $this->belongsTo(Lingua::class, 'lingua');
    }
}
