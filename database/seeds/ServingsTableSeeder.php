<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('servings')->insert([
            'title' => '300 ml',
        ]);
        DB::table('servings')->insert([
            'title' => '600 ml',
        ]);
        DB::table('servings')->insert([
            'title' => '1000 ml',
        ]);
    }
}
