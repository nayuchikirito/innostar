<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coordination extends Model
{
    use SoftDeletes;
    // protected $dateFormat = 'Y-m-d H:i';
	protected $dates = ['date', 'deleted_at'];
    
    protected $fillable = [
        'date', 'status', 'balance', 'client_id', 'service_id'
    ];

    public function client(){
    	return $this->belongsTo('App\Client');
    }

    public function service(){
    	return $this->belongsTo('App\Service');
    }
}
