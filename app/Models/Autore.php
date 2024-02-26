<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Autore extends Model
{

    use Searchable;
    protected $table = 'autori';
    protected $primaryKey = 'id_autore';
    protected $fillable = ['autore'];
    public $timestamps = false;

    public function toSearchableArray()
    {
        $array = ['autore' => $this->autore];

        return $array;
    }


    public function belongsScheda() {
        return $this->belongsTo(Scheda_Autore::class, 'id_autore');
    }

    public function belongsLibri() {
        return $this->belongsToMany(Libro::class, 'libri_autori', 'id_autore', 'ISBN');
    }
}
