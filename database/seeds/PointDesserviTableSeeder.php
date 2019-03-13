<?php

use Illuminate\Database\Seeder;

class PointDesserviTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PointDesservi::class,16)->create();
    }
}
