<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Admin extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id_user';
    public $timestamps = false;
    public $incrementing = false;

    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
