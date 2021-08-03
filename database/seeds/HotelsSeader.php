<?php

use Illuminate\Database\Seeder;

class HotelsSeader extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Hotels::class, 10)->create()->each(function ($hotel) {
            $hotel->save();
        });
    }
}
