<?php

use App\User;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 4)->create()->each(function ($user) {
            $this->attachAdresses($user, 3);
        });
    }

    protected function attachAdresses(User $user, int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            $user->addresses()->save(factory(App\Address::class)->make());
        }
    }
}
