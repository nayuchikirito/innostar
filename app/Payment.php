<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $dates = ['created_at', 'updated_at'];
    
    protected $fillable = [
        'or', 'amount', 'type', 'reservation_id'
    ];

    public function reservation(){
    	return $this->belongsTo('App\Reservation');
    }

}
