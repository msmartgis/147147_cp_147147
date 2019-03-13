<?php

use Illuminate\Database\Seeder;

class MoaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Moa::class,20)->create();
    }
}
