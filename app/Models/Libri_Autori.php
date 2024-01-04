<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libri_Autori extends Model
{
    protected $table = 'libri_autori';
    protected $primaryKey = 'ISBN';
    protected $fillable = ['id_autore', 'ISBN'];
    const UPDATED_AT = null;
    const CREATED_AT = null;

    public function belongsAutore() {
        return $this->belongsTo(Autore::class, 'id_autore');
    }
}
