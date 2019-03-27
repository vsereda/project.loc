<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Awobaz\Compoships\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderDishServing extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'order_dishserving';

    public function order()
    {
        $this->belongsTo('App\Order', 'order_id', 'id');
    }

    public function dishServing()
    {
        return $this->belongsTo('App\DishServing', ['dish_id', 'serving_id'], ['dish_id', 'serving_id']);
    }
}