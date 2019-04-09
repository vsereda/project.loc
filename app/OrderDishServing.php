<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Awobaz\Compoships\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use CoenJacobs\EloquentCompositePrimaryKeys\HasCompositePrimaryKey;

class OrderDishServing extends Model
{
    use \Awobaz\Compoships\Compoships;
    use HasCompositePrimaryKey;

    protected $table = 'order_dishserving';
    protected $fillable = ['order_id', 'dish_id', 'serving_id', 'count'];
    protected $primaryKey = array('order_id', 'dish_id', 'serving_id');

    public function order()
    {
        $this->belongsTo('App\Order', 'order_id', 'id');
    }

    public function dishServing()
    {
        return $this->belongsTo('App\DishServing', ['dish_id', 'serving_id'], ['dish_id', 'serving_id']);
    }
}