<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Stefan Lutu',
            'email' => 'lutu.stefan@yahoo.com',
            'owner' => 1,
            'password' => bcrypt('password')
        ]);

        factory(App\User::class, 5)->create()->each(function ($user) {
            $user->save();
        });
    }
}
