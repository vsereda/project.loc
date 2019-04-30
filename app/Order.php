<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'dinner_time', 'status', 'execution'];

//    public function address()
//    {
//        return $this->belongsTo('App\Address');
//    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function orderDishServings()
    {
        return $this->hasMany('App\OrderDishServing', 'order_id', 'id');
    }
}