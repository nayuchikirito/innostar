<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'date', 'status', 'balance', 'client_id', 'service_id'
    ];

    public function client(){
    	return $this->belongsTo('App\Client');
    }

    public function package(){
    	return $this->belongsTo('App\Package');
    }
}
