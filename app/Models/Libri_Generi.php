<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libri_Generi extends Model
{
    protected $table = 'libri_generi';
    protected $primaryKey = ['ISBN', 'id_genere'];
    public $incrementing = false;
    protected $fillable = ['ISBN','id_genere'];
    const UPDATED_AT = null;
    const CREATED_AT = null;

    public function belongsGenere() {
        return $this->belongsTo(Genere::class, 'id_genere');
    }
}
