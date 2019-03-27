<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serving extends Model
{
    public function dishServings()
    {
        return $this->hasMany('App\DishServing');
    }
}
