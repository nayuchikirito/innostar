<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientNotificationCoord extends Model
{
    protected $table = 'client_notification_coords';

    protected $fillable = [
        'coordination_id', 'status', 'type', 'change_date',
    ];

    public function coordination()
    {
    	return $this->belongsTo('\App\Coordination');
    }}
