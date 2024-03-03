<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prenotazione extends Model {

    protected $table = 'prenotazioni';
    protected $primaryKey = 'id_prenotazione';
    protected $fillable = ['user', 'id_copia'];
    const UPDATED_AT = null;

    public function belongsCopia() : BelongsTo
    {
        return $this->belongsTo(Copia::class, 'id_copia', 'id_copia');  
    }

    public function belongsUser() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }
}
