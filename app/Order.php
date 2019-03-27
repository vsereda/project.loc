<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function address()
    {
        return $this->belongsTo('App\Address');
    }

    public function orderDishServings()
    {
        return $this->hasMany('App\OrderDishServing', 'order_id', 'id');
    }
}
