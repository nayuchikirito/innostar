<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierNotification extends Model
{
    public function reservation_detail(){
        return $this->belongsTo('App\ReservationDetail');
    }
}
