<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationDetail extends Model
{
    public function package_detail(){
        return $this->belongsTo('App\PackageDetail');
    }
    public function reservation(){
        return $this->belongsTo('App\Reservation');
    }
}
