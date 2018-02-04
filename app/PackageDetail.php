<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageDetail extends Model
{
	protected $table = 'package_details';
    protected $fillable = [
        'package_description_id', 'package_id', 'price',
    ];

    public function package_description(){
        return $this->hasMany('App\PackageDescription');
    }

    public function package(){
        return $this->hasMany('App\Package');
    }
}
}
