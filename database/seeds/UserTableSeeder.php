<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 10 quantidade de usuários que quero criar.
        factory(\CodeDelivery\Models\User::class, 10)->create()->each(function($u){
            $u->client()->save(factory(\CodeDelivery\Models\Client::class)->make());
        });
    }
}
