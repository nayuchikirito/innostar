<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientNotification extends Model
{
    protected $table = 'client_notifications';

    protected $fillable = [
        'reservation_id', 'status', 'type', 'change_date',
    ];

    public function reservation()
    {
    	return $this->hasMany('\App\Reservation');
    }
}
