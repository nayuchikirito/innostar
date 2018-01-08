<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Supplier extends Authenticatable
{
    use Notifiable;

    protected $table = 'suppliers';
    
    protected $fillable = [
        'user_id', 'type',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }


}
