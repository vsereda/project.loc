<?php

namespace App\Services\Kitchen;

use App\Order;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class KitchenOrders
{
    public function get(int $paginate): ?LengthAwarePaginator
    {
        return Order::where('execution', Carbon::now()->format('Y-m-d'))
            ->orderBy('dinner_time')
            ->orderBy('id')
            ->paginate($paginate);
    }
}