<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at', 'date'];
    // protected $dateFormat = 'Y-m-d H:i';
    
    protected $fillable = [
        'date', 'status', 'balance', 'client_id', 'package_id'
    ];

    public function client(){
    	return $this->belongsTo('App\Client');
    }

    public function package(){
    	return $this->belongsTo('App\Package');
    }

    public function payment(){
        return $this->hasMany('App\Payment');
    }

    public function assign_supplier(){
        return $this->hasMany('App\Reservation');
    }

    public function details(){
        return $this->hasMany('App\ReservationDetail');
    }

    public function client_notif(){
        return $this->hasMany('App\CLientNotification');
    }

    public function client_notif_coord(){
        return $this->hasMany('App\CLientNotificationCoord');
    }

    // public function getDateAttribute($value) {
    //     return \Carbon\Carbon::parse($value)->format('Y-m-d');
    // }
}
