<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageDescription extends Model
{
	protected $table = 'package_descriptions';
    protected $fillable = [
        'name',
    ];

    public function package_detail(){
        return $this->hasMany('App\PackageDetail');
    }
}
