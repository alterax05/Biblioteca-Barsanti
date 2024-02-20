<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reparto;

class Genere extends Model
{
    protected $table = 'generi';
    protected $primaryKey = 'id_genere';
    protected $fillable = ['genere'];
    protected $timestamps = false;

    public function belongsLibri() {
        return $this->belongsToMany(Libro::class, 'libri_generi', 'ISBN', 'id_genere');
    }
}
