<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $table = 'dishes';

    public function dishServings(){
        return $this->hasMany('App\DishServing',  'dish_id', 'id');
    }
}
