<?php

use Illuminate\Database\Seeder;

class PisteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Piste::class,200)->create();
    }
}
