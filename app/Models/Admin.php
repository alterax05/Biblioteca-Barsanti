<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id_user';
    const UPDATED_AT = null;
    const CREATED_AT = null;
}
