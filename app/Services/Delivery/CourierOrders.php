<?php

namespace App\Services\Delivery;

use App\Order;
use Carbon\Carbon;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CourierOrders
{
    public function get(int $paginate): ?AbstractPaginator
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
            ->paginate($paginate);
    }
}