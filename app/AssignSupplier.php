<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AssignSupplier extends Authenticatable
{
    use Notifiable;

    protected $table = 'assign_suppliers';

    protected $fillable = [
        'price', 'status', 'supplier_id', 'reservation_id'
    ];

    public function supplier(){
        return $this->belongsTo('App\Supplier');
    }

    public function reservation(){
        return $this->belongsTo('App\Reservation');
    }
}
