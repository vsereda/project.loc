<?php

use App\Address;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(App\User::class, 4)->create()->each(function ($user) {
//            $this->attachAdresses($user, 3);
//        });
        factory(App\Address::class, 4)->create()->each(function ($address) {
            $this->attachUsers($address, 3);
        });

        DB::table('addresses')->insert([
            'description' => 'ул.Созовская, 100500',
        ]);
    }

    /**
     * @param User $user
     * @param int $count
     *
     * Copyed to LaratrustSeeder
     */
    protected function attachUsers(Address $address, int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            $address->users()->save(factory(App\User::class)->make());
        }
    }
}