<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $table = 'dishes';

    public function dishServings()
    {
        return $this->hasMany('App\DishServing', 'dish_id', 'id');
    }

    public function servings()
    {
        return $this->belongsToMany(
            'App\Serving',
            'dish_serving',
            'dish_id',
            'serving_id',
            'id',
            'id'
        )->withPivot('price')->withTimestamps();
    }
}