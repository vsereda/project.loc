<?php

use App\DishServing;
use App\Order;
use App\OrderDishServing;
use Illuminate\Database\Seeder;

class OrderDishServingTableSeeder extends Seeder
{
    // Order count and dishServing count for each Order
    const ORDERS = 120;
    const DISHSERVINGS = 3;

    // Those variables are using for DishServings cache
    protected $dishServings;
    protected $availableDSs;
    protected $current;

    public function __construct()
    {
        $this->dishServings = DishServing::all(['dish_id', 'serving_id']);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Order::class, self::ORDERS)->create()->each(function ($order) {

            // Cloning all DishServings to available DSs
            $this->availableDSs = clone $this->dishServings;

            // Attaching each Order to DishServings (choose DS count or const count, what is smaller)
            $this->AttachDishServing(
                $order,
                mt_rand(1, (self::DISHSERVINGS < $this->dishServings->count() ? self::DISHSERVINGS : $this->dishServings->count()))
            );

            // Resetting variables
            $this->availableDSs = null;
            $this->current = null;
        });
    }

    protected function AttachDishServing(Order $order, int $count)
    {
        for ($i = 0; $i < $count; $i++) {

            // Getting next collection item from available DSs
            $this->availableDSs = $this->availableDSs->shuffle();
            $this->current = $this->availableDSs->shift();

            // Attaching DishServing to Order
            $order->orderDishServings()
                ->save(factory(App\OrderDishServing::class)
                    ->make([
                        'dish_id' => $this->current->dish_id,
                        'serving_id' => $this->current->serving_id,
                    ]));
        }
    }
}