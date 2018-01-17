<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];

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
