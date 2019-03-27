<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDishServing extends Model
{
    protected $table = 'order_dishserving';

    public function order()
    {
        $this->belongsTo('App\Order', 'order_id', 'id');
    }

//    public function dishServing()
//    {
//        $this->belongsTo('App\DishServing', , );
//    }

}
