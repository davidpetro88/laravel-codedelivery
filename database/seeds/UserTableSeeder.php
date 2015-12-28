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
        factory(\CodeDelivery\Models\User::class)->create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt(123456),
            'remember_token' => str_random(10),
        ])->client()->save(factory(\CodeDelivery\Models\Client::class)->make());

        factory(\CodeDelivery\Models\User::class)->create([
            'name' => 'Admin',
            'email' => 'admin@user.com',
            'password' => bcrypt(123456),
            'role' => 'admin',
            'remember_token' => str_random(10),
        ])->client()->save(factory(\CodeDelivery\Models\Client::class)->make());

        // 10 quantidade de usuários que quero criar.
        factory(\CodeDelivery\Models\User::class, 10)->create()->each(function($u){
            $u->client()->save(factory(\CodeDelivery\Models\Client::class)->make());
        });

        factory(\CodeDelivery\Models\User::class, 3)->create([
            'role' => 'deliveryman',
        ]);
    }
}