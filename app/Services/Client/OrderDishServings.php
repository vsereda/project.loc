<?php

namespace App\Services\Client;

use App\Order;
use App\OrderDishServing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OrderDishServings
{
    public function create(Request $validatedData, Order $order)
    {
        foreach ($validatedData['dish_servings'] as $key => $ds) {
            if (null !== $ds) {
                $delimiterPosition = strpos($key, '/');
                OrderDishServing::create([
                    'order_id' => $order->id,
                    'dish_id' => substr($key, 0, $delimiterPosition),
                    'serving_id' => substr($key, $delimiterPosition + 1),
                    'count' => $ds,
                ]);
            }
        };
    }
}