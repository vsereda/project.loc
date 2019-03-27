<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serving extends Model
{
    public function dishServings()
    {
        return $this->hasMany('App\DishServing');
    }

    public function dishes()
    {
        return $this->belongsToMany(
            'App\Dish',
            'dish_serving',
            'serving_id',
            'dish_id'
        )->withPivot('price')->withTimestamps();
    }
}