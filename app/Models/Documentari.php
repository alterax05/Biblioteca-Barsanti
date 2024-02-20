<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documentari extends Model
{
    protected $table = 'documentari';
    protected $primaryKey = 'id_documentario';
    protected $fillable = ['titolo', 'subtitolo', 'uploader', 'embed', 'tipologia', 'link', 'thumbnail', 'fornitore'];
    protected $timestamps = false;

    public function belongsUser() {
        return $this->belongsTo(User::class, 'uploader');
    }

    public function belongsTipologia() {
        return $this->belongsTo(Reparto::class, 'tipologia');
    }
}
