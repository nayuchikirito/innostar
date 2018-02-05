<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentCoordination extends Model
{
	protected $table = 'payment_coordinations';
   	protected $dates = ['created_at', 'updated_at'];
    
    protected $fillable = [
        'or', 'amount', 'type', 'coordination_id'
    ];

    public function coordination(){
    	return $this->belongsTo('App\Coordination');
    }
}
