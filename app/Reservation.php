<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'date', 'status', 'balance', 'client_id', 'service_id'
    ];
}
