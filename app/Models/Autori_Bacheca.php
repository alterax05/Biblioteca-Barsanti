<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autori_Bacheca extends Model
{
    protected $table = 'autori_bacheca';

    protected $primaryKey = 'id_autore';

    public $incrementing = false;

    protected $keyType = 'bigint';

    const UPDATED_AT = null;

    protected $fillable = [
        'id_autore',
        'subtitle',
        'created_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}