<?php

namespace App\Services\Client;

use App\DishServing;
use App\Order;
use App\OrderDishServing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TotalCost
{
    public function get(array $dishServingCounts)
    {
        $total = 0;
        foreach ($dishServingCounts as $dsCount) {
            $total += $dsCount['count'] * $dsCount['ds']->price;
        }
        return $total;
    }
}