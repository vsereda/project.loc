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
            'title' => 'Борщ',
            'description' => 'Самый лучший борщ'
        ]);
        DB::table('dishes')->insert([
            'title' => 'Суп',
            'description' => 'Самый лучший суп'
        ]);
        DB::table('dishes')->insert([
            'title' => 'Вареники',
            'description' => 'Самые лучшие вареники'
        ]);
        DB::table('dishes')->insert([
            'title' => 'Пельмени',
            'description' => 'Самые лучшие пельмени'
        ]);
    }
}
