<?php

namespace App\Services\Kitchen;

use App\Order;
use App\OrderDishServing;
use App\User;
use Carbon\Carbon;
use App\Address;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class KitchenOrders
{
    protected $bufferSum = [];

    public function get(): ?Collection
    {
        return Order::join('users', 'users.id', '=', 'orders.user_id')
            ->orderBy('orders.dinner_time')
            ->orderBy('users.address_id')
            ->orderBy('orders.user_id')
            ->orderBy('orders.id')
            ->select('orders.*')
            ->with('user.address')
            ->with('orderDishServings.dishServing.dish')
            ->with('orderDishServings.dishServing.serving')
            ->where('orders.execution', Carbon::now()->format('Y-m-d'))
            ->get()
            ->groupBy('dinner_time')
            ->map(function ($item, $key) {
                return $item->groupBy('user.address.description')
                    ->map(function ($item, $key) {
                        return $item->map(function ($item, $key) {
                            return $item->orderDishServings;
                        })->flatten();
                    })//                    ->flatten()
                    ;
            })
            ->map(function ($item, $key) {
                return $item->map(function ($item, $key) {

//                dump($key); //ODS
//                dump($item); //ODS
                $this->bufferSum = [];
                $item->map(function ($item, $key) {
                    if (isset($this->bufferSum[$item->dish_id . '_' . $item->serving_id])) {
                        $this->bufferSum[$item->dish_id . '_' . $item->serving_id]['count'] += $item->count;
                        $this->bufferSum[$item->dish_id . '_' . $item->serving_id] = collect($this->bufferSum[$item->dish_id . '_' . $item->serving_id]);
                    } else {
                        $this->bufferSum[$item->dish_id . '_' . $item->serving_id]['dishServing'] = $item->dishServing;
                        $this->bufferSum[$item->dish_id . '_' . $item->serving_id]['count'] = $item->count;
                        $this->bufferSum[$item->dish_id . '_' . $item->serving_id] = collect($this->bufferSum[$item->dish_id . '_' . $item->serving_id]);
                    }
                });
//                dump($this->bufferSum);
                return collect($this->bufferSum)->sort()->values();
//                dump($item);
//                return $item;
                });
    });
}
}