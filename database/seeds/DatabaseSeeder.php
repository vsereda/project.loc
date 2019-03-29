<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DishesTableSeeder::class);
        $this->call(ServingsTableSeeder::class);
        $this->call(DishServingTableSeeder::class);
        $this->call(AddressesTableSeeder::class);
        $this->call(OrderDishServingTableSeeder::class);

        // Laratrust
        $this->call(LaratrustSeeder::class);
    }
}