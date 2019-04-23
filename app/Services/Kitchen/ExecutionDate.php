<?php

namespace App\Services\Kitchen;

use App\Order;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ExecutionDate
{
    public function get(): Carbon
    {
        switch (Carbon::tomorrow()->dayOfWeek) {
            case 6:
                return Carbon::now()->addDays(3);
            case 0:
                return Carbon::now()->addDays(2);
            default:
                return Carbon::tomorrow();
        }
    }
}