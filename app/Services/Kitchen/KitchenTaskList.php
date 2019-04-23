<?php

namespace App\Services\Kitchen;

use App\Order;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class KitchenTaskList
{
    public function get(int $dinnerTime = 0): Collection
    {
        $list = self::getNotMadeOrders($dinnerTime)->map(function ($item) {
            return $item->orderDishServings;
        })
            ->collapse()
            ->groupBy(function ($item) {
                return $item->dishServing->dish->title;
            })
            ->map(function ($item) {
                return $item->groupBy(function ($item) {
                    return $item->dishServing->serving->title;
                })->map(function ($item) {
                    $res3 = $item;
                    return $res3->sum('count');
                });
            });
        return $list;
    }

    protected function getNotMadeOrders(int $dinnerTime = 0)
    {
        $dinnerTimeList = $dinnerTime ? [$dinnerTime] : [1, 2, 3];
        return Order::where('execution', Carbon::now()->format('Y-m-d'))
            ->whereIn('status', [1])
            ->whereIn('dinner_time', $dinnerTimeList)
            ->with(['orderDishServings'])
            ->get();
    }
}