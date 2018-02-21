<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */ 
    protected $fillable = [
        'fname', 'lname', 'midname', 'email', 'password', 'location', 'contact', 'user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function supplier(){
        return $this->hasOne('\App\Supplier');
    }

    public function client(){
        return $this->hasOne('\App\Client', 'user_id');
    }

    public function messages(){
        return $this->hasMany('\App\Message');
    }
    

    public function setPasswordAttribute($password) {
        $this->attributes['password'] = bcrypt($password);
    }

    public function setFnameAttribute($fname) {
        $this->attributes['fname'] = ucfirst($fname);
    }

    public function setLnameAttribute($lname) {
        $this->attributes['lname'] = ucfirst($lname);
    }

    public function setMidnameAttribute($midname) {
        $this->attributes['midname'] = ucfirst($midname);
    }

    public function setLocationAttribute($location) {
        $this->attributes['location'] = ucfirst($location);
    }



}
