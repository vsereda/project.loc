<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DishServing extends Model
{
    protected $table = 'dish_serving';

    public function dish()
    {
        return $this->belongsTo('App\Dish');
    }

    public function serving()
    {
        return $this->belongsTo('App\Serving');
    }
}
