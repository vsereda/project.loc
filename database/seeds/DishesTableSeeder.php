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
            'title' => 'Borsch',
            'description' => 'The best borsch'
        ]);
        DB::table('dishes')->insert([
            'title' => 'Soup',
            'description' => 'The best soup'
        ]);
        DB::table('dishes')->insert([
            'title' => 'Vareniki',
            'description' => 'The best vareniki'
        ]);
        DB::table('dishes')->insert([
            'title' => 'Pelmeni',
            'description' => 'The best pelmeni'
        ]);
    }
}
