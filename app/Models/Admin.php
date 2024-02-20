<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id_user';
    protected $keyType = 'bigint';
    protected $incrementing = true;
    protected $timestamps = false;
}
