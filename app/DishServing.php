<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Awobaz\Compoships\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

//class DishServing extends Model
class DishServing extends Pivot
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'dish_serving';

    public function dish()
    {
        return $this->belongsTo('App\Dish');
    }

    public function serving()
    {
        return $this->belongsTo('App\Serving');
    }

    public function orderDishServings()
    {
        return $this->hasMany('App\OrderDishServing', ['dish_id', 'serving_id'], ['dish_id', 'serving_id']);
    }
}