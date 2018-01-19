<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at', 'date'];

    protected $fillable = [
        'date', 'status', 'balance', 'client_id', 'package_id'
    ];

    public function client(){
    	return $this->belongsTo('App\Client');
    }

    public function package(){
    	return $this->belongsTo('App\Package');
    }

    // public function getDateAttribute($value) {
    //     return \Carbon\Carbon::parse($value)->format('Y-m-d');
    // }
}
