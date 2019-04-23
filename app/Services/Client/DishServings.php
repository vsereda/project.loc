<?php

namespace App\Services\Client;

use App\DishServing;
use App\Order;
use App\OrderDishServing;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DishServings
{
    public function get(Collection $dishServingIDs): Collection
    {
        foreach ($dishServingIDs as $ds) {
            $dishServings[] = DishServing::find([
                'dish_id' => substr($ds, 0, strpos($ds, '/')),
                'serving_id' => substr($ds, strpos($ds, '/') + 1),
            ]);
        }
        return collect($dishServings);
    }

    public function getCounts(Collection $dishservings, Collection $dsString)
    {
        $dishServingCounts = [];
        foreach ($dishservings as $key => $ds) {
            $dishServingCounts[] = [
                'ds' => $ds,
                'count' => $dsString->flatten()[$key],
            ];
        }
        return $dishServingCounts;
    }

    public function dsString(FormRequest $request)
    {
        return collect($request->dish_servings)->filter(function ($value, $key) {
            return is_numeric($value) && $value > 0;
        });
    }
}