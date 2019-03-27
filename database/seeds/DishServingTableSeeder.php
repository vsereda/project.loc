<?php

use App\Dish;
use App\Serving;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DishServingTableSeeder extends Seeder
{
    protected $dishes;

    public function __construct()
    {
        $this->dishes = Dish::all();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Serving::all()->each(function ($serving) {
            $this->attachDishes($serving, $this->dishes);
        });
    }

    protected function attachDishes(Serving $serving, Collection $dishes): void
    {
        foreach ($dishes as $dish) {
            DB::table('dish_serving')->insert([
                'dish_id' => $dish->id,
                'serving_id' => $serving->id,
                'price' => rand(30, 300),
            ]);
        }
    }
}