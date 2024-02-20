<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preferiti extends Model {

    protected $table = 'preferiti';
    protected $primaryKey = 'preferiti';
    protected $fillable = ['id_user', 'ISBN'];
    protected $timestamps = false;
}
