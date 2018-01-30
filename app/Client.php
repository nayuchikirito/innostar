<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $fillable = [
        'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function reservation(){
    	return $this->hasMany('App\Reservation');
    }

    public function coordination(){
        return $this->hasMany('App\Coordination');
    }
}
