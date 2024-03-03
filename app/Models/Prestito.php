<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prestito extends Model
{
    protected $table = 'prestiti';
    protected $primaryKey = 'id_prestito';
    protected $fillable = ['id_copia', 'id_user', 'data_inizio', 'data_fine'];
    public $timestamps = false;

    public function belongsUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function belongsCopia():  BelongsTo
    {
        return $this->belongsTo(Copia::class, 'id_copia', 'id_copia');
    }
}
