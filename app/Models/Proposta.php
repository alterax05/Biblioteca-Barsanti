<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposta extends Model {

    protected $table = 'proposte';
    public $incrementing = false;
    protected $fillable = ['ISBN', 'user', 'status'];
    const UPDATED_AT = null;
}
