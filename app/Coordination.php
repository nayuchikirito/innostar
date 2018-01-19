<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coordination extends Model
{
    protected $fillable = [
        'date', 'status', 'balance', 'client_id', 'service_id'
    ];

    public function client(){
    	return $this->belongsTo('App\Client');
    }

    public function service(){
    	return $this->belongsTo('App\Service');
    }
}
