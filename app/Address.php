<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $table = 'addresses';
    protected $fillable = ['description', ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

//    public function orders()
//    {
//        return $this->hasMany('App\Order');
//    }
}