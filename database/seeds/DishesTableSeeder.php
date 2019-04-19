<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DishesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dishes')->insert([
            'title' => 'Суп 1',
            'description' => 'Описание блюда суп 1'
        ]);
        DB::table('dishes')->insert([
            'title' => 'Суп 2',
            'description' => 'Описание блюда суп 2'
        ]);
        DB::table('dishes')->insert([
            'title' => 'Суп 3',
            'description' => 'Описание блюда суп 3'
        ]);
        DB::table('dishes')->insert([
            'title' => 'Суп 4',
            'description' => 'Описание блюда суп 4'
        ]);
    }
}
