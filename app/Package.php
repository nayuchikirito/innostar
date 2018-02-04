<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
	
    protected $fillable = [
        'name', 'price', 'description', 'service_id'
    ];

    public function service(){
        return $this->belongsTo('App\Service');
    }

    public function reservation(){
        return $this->hasMany('App\Reservation');
    }

    public function pacakge_detail(){
        return $this->belongsTo('App\PackageDetail');
    }

}
