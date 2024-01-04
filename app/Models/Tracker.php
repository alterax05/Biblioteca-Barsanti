<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracker Extends Model {

    public $attributes = ['hits' => 0];

    protected $fillable = ['ip', 'date', 'user'];

    public $timestamps = false;

    protected $table = 'tracker';

    public static function boot() {
        // When a new instance of this model is created...
        parent::boot();
        static::creating(function ($tracker) {
            $tracker->hits = 0;
        } );

        // Any time the instance is saved (create OR update)
        static::saving(function ($tracker) {
            $tracker->visit_date = date('Y-m-d');
            $tracker->visit_time = date('H:i:s');
	    $tracker->user = (Auth()->check())?Auth()->id():0;
            $tracker->hits++;
        } );
    }

// Fill in the IP and today's date
    public function scopeCurrent($query) {
        return $query->where('ip', $_SERVER['REMOTE_ADDR'])
            ->where('date', date('Y-m-d'));
    }

    public static function hit() {
        /* $test= request()->server('REMOTE_ADDR');
         echo $test;
         exit();*/
        static::firstOrCreate([
            'ip'   => $_SERVER['REMOTE_ADDR'],
            'date' => date('Y-m-d'),
            'user' => (Auth()->check())?Auth()->id():0
            // exit()
        ])->save();

    }
}
